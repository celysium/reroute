<?php

namespace Celysium\Reroute\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RerouteToLocal
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(Request): (Response) $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (env('APP_ENV') !== 'local') {
            return $next($request);
        }

        $requestedUri = trim($request->getRequestUri(), '/');

        $urlArray = explode('/', $requestedUri);

        if ($urlArray[3] === env('MICROSERVICE_PREFIX')) {
            unset($urlArray[3]);

            $finalRequestUri = '/' . implode('/', $urlArray);

            $final_request = Request::create(
                $finalRequestUri,
                $request->method(),
                $request->all(),
                $request->cookies->all(),
                $request->allFiles());

            foreach ($request->headers as $key => $header) {
                $final_request->headers->set($key, $header);
            }

            return $next($final_request);
        }

        return $next($request);
    }
}
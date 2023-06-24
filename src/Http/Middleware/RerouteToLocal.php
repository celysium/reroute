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

            $referer = $request->server->get('HTTP_REFERER');

            $finalReferer = \Str::replace($request->getRequestUri(), $finalRequestUri, $referer);

            $request->server->set('HTTP_REFERER', $finalReferer);
            $request->server->set('REQUEST_URI', $finalRequestUri);
        }

        return $next($request);
    }
}

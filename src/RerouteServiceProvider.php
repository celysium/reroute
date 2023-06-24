<?php

use Illuminate\Support\ServiceProvider;
use Celysium\Http\Middleware\RerouteToLocal;
class RerouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $router = $this->app['router'];

        $router->aliasMiddleware('reroute-to-localhost', RerouteToLocal::class);
        // or
        $router->pushMiddlewareToGroup('api', RerouteToLocal::class);
    }
}
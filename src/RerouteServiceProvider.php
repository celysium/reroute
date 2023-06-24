<?php

namespace Celysium\Reroute;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Celysium\Reroute\Http\Middleware\RerouteToLocal;
use Illuminate\Contracts\Http\Kernel;

class RerouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $kernel = app(Kernel::class);
        $kernel->pushMiddleware(RerouteToLocal::class);
    }
}
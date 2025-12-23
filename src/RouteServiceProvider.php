<?php

namespace LiraUi\Auth;

use Illuminate\Support\ServiceProvider;
use Spatie\RouteAttributes\RouteRegistrar;

/** @property \Illuminate\Foundation\Application $app */
class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (! $this->shouldRegisterRoutes()) {
            return;
        }

        $routeRegistrar = $this->app->make(RouteRegistrar::class, [
            $this->app->router,
        ]);

        $routeRegistrar->useBasePath(__DIR__.'/Http/Controllers');
        $routeRegistrar->useRootNamespace('LiraUi\Auth\Http\Controllers');
        $routeRegistrar->registerDirectory(__DIR__.'/Http/Controllers');
    }

    private function shouldRegisterRoutes(): bool
    {
        if (! config('route-attributes.enabled')) {
            return false;
        }

        if ($this->app->routesAreCached()) {
            return false;
        }

        return true;
    }
}

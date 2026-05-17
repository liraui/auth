<?php

namespace LiraUi\Auth\Tests;

use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\Concerns\InteractsWithAuthentication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\ServiceProvider as InertiaServiceProvider;
use Laravel\Passkeys\PasskeysServiceProvider;
use LiraUi\Auth\AuthServiceProvider;
use LiraUi\Auth\RouteServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    use InteractsWithAuthentication;
    use RefreshDatabase;

    /**
     * Define environment setup.
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Define database migrations.
     */
    protected function defineDatabaseMigrations()
    {
        $this->loadLaravelMigrations();

        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->loadMigrationsFrom(__DIR__.'/../vendor/laravel/passkeys/database/migrations');
    }

    /**
     * Define environment setup.
     *
     * @param  Application  $app
     */
    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('app.key', 'base64:'.base64_encode(random_bytes(32)));

        $app['config']->set('route-attributes.enabled', true);

        $app['config']->set('auth.providers.users.model', User::class);
    }

    /**
     * Define routes for the test environment.
     */
    protected function defineRoutes($router): void
    {
        $router->get('/password/confirm', fn () => 'confirm')->name('password.confirm');
    }

    /**
     * Get package providers.
     */
    protected function getPackageProviders($app)
    {
        return [
            InertiaServiceProvider::class,
            AuthServiceProvider::class,
            PasskeysServiceProvider::class,
            RouteServiceProvider::class,
        ];
    }
}

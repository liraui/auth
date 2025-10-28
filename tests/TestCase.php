<?php

namespace LiraUi\Auth\Tests;

use LiraUi\Auth\AuthServiceProvider;
use LiraUi\Auth\RouteServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /**
     * Define environment setup.
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Get package providers.
     */
    protected function getPackageProviders($app)
    {
        return [
            RouteServiceProvider::class,
            AuthServiceProvider::class,
        ];
    }
}

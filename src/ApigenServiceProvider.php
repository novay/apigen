<?php

namespace Novay\Apigen;

use Illuminate\Support\ServiceProvider;

class ApigenServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'apigen');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        $this->registerConfig();
        $this->configurePublishing();
    }

    public function register()
    {
        $this->registerRouteMiddleware();
    }

    protected function registerConfig()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/apigen.php', 'apigen');

        $this->publishes([__DIR__.'/../config' => config_path()], 'apigen-config');
    }

    protected function configurePublishing()
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__.'/../database/migrations/2014_10_12_000000_create_apigen_table.php' => database_path('migrations/2014_10_12_000000_create_apigen_table.php')
        ], 'apigen-migrations');
    }

    protected function registerRouteMiddleware()
    {
        app('router')->aliasMiddleware('connect', Http\Middleware\Connect::class);
        app('router')->aliasMiddleware('disconnect', Http\Middleware\Disconnect::class);
    }
}

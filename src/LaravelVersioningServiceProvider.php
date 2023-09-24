<?php

namespace ikepu_tp\LaravelVersioning;

use Illuminate\Support\ServiceProvider;

class LaravelVersioningServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/config/laravel-versioning.php', 'laravel-versioning');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerPublishing();
        $this->defineRoutes();
        $this->loadViewsFrom(__DIR__ . "/resources/views", "LaravelVersioning");
    }

    /**
     * Register the package's publishable resources.
     */
    private function registerPublishing()
    {
        if (!$this->app->runningInConsole()) return;

        $this->publishView();

        return;

        $this->publishes([
            __DIR__ . '/config/laravel-versioning.php' => base_path('config/laravel-versioning.php'),
        ], 'LaravelVersioning-config');
    }

    private function publishView(): void
    {
        $this->publishes([
            __DIR__ . '/resources/views' => resource_path('views/vendor/LaravelVersioning'),
        ], 'LaravelVersioning-views');
    }

    /**
     * Define the routes.
     *
     * @return void
     */
    protected function defineRoutes()
    {
        $this->loadRoutesFrom(__DIR__ . "/routes/web.php");
    }
}

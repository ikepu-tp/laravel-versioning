<?php

namespace ikepu_tp\LaravelVersioning;

use ikepu_tp\LaravelVersioning\app\Console\Commands\DeployCommand;
use ikepu_tp\LaravelVersioning\app\Console\Commands\InstallCommand;
use ikepu_tp\LaravelVersioning\app\Console\Commands\MakeCommand;
use Illuminate\Support\ServiceProvider;

class LaravelVersioningServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/config/versioning.php', 'versioning');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->defineRoutes();
        $this->loadViewsFrom(__DIR__ . "/resources/views", "LaravelVersioning");
        if (!$this->app->runningInConsole()) return;
        $this->registerPublishing();
        $this->commands([
            InstallCommand::class,
            MakeCommand::class,
            DeployCommand::class,
        ]);
    }

    /**
     * Register the package's publishable resources.
     */
    private function registerPublishing()
    {

        $this->publishView();

        return;

        $this->publishes([
            __DIR__ . '/config/versioning.php' => base_path('config/versioning.php'),
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

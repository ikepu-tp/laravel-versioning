<?php

namespace Tests;

use ikepu_tp\LaravelVersioning\LaravelVersioningServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

// Define App\Http\Controllers\Controller if it doesn't exist (for package testing)
if (!class_exists('App\Http\Controllers\Controller')) {
    eval("namespace App\Http\Controllers; class Controller extends \Illuminate\Routing\Controller {}");
}

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            LaravelVersioningServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('app.key', 'base64:' . base64_encode(str_repeat('a', 32)));
        // Set app environment to local so editor middleware allows access by default
        $app['env'] = 'local';

        // Create app.blade.php required by Inertia
        $viewPath = resource_path('views');
        if (!is_dir($viewPath)) {
            mkdir($viewPath, 0755, true);
        }
        file_put_contents(
            $viewPath . '/app.blade.php',
            '<!DOCTYPE html><html><head>@inertiaHead</head><body>@inertia</body></html>'
        );
    }
}

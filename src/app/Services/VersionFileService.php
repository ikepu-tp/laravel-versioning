<?php

namespace ikepu_tp\LaravelVersioning\app\Services;

use Exception;

class VersionFileService extends Service
{
    public static function saveVersions(array $versions): void
    {
        file_put_contents(
            base_path('version.json'),
            json_encode($versions, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL
        );
    }

    public static function getVersions(): array
    {
        $path = base_path("version.json");
        if (!file_exists($path))
            throw new Exception("Could not find `version.json` file.");

        $file = file_get_contents($path);
        return json_decode($file, true);
    }
}
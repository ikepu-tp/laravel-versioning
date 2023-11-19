<?php

namespace ikepu_tp\LaravelVersioning\app\Services;

use Exception;

class VersionFileService extends Service
{
    public static function saveVersions(array $versions): void
    {
        self::saveJson(base_path("version.json"), $versions);
    }

    public static function getVersions(): array
    {
        return self::getJson(base_path("version.json"));
    }

    public static function getJson(string $path): array
    {
        if (!file_exists($path)) throw new Exception("Could not find `{$path}`");

        $file = file_get_contents($path);
        return json_decode($file, true);
    }

    public static function saveJson(string $path, array $json): void
    {

        file_put_contents(
            $path,
            json_encode($json, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . PHP_EOL
        );
    }
}
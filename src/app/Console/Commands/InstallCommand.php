<?php

namespace ikepu_tp\LaravelVersioning\app\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'versioning:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install laravel-versioning.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Creating files");
        foreach ([".github/workflows/release.yml", 'version.json'] as $val) {
            $this->copyFile(self::basePath() . "/{$val}", base_path($val));
        }
    }

    protected function copyFile(string $path, string $target, bool $check_exists = true): void
    {
        if ($check_exists && file_exists($target)) return;
        copy($path, $target);
        $this->info($path . " is copied to" . $target);
    }

    protected static function basePath(): string
    {
        return __DIR__ . "/../../../";
    }
}

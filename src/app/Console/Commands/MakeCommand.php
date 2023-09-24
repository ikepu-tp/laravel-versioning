<?php

namespace ikepu_tp\LaravelVersioning\app\Console\Commands;

use Illuminate\Console\Command;

class MakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'versioning:make
                            {--V|version= : version type (major, minor, patch)}
                            {--J|major : version type is major}
                            {--M|minor : version type is minor}
                            {--P|patch : version type is patch}
                            ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate release note.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
    }

    protected function getVersions()
    {
        $path = base_path("version.json");
        if (!file_exists($path)) {
            $this->error("Could not find `version.json` file.");
            return;
        }

        $file = file_get_contents($path);
        $versions = json_decode($file, true);
        return $versions;
    }

    protected function generateReleaseNote()
    {
        $newVersion = [
            "version" => "",
            "releaseDate" => "",
            "Author" => "",
            "url" => "",
            "description" => "",
            "newFeatures" => "",
            "changedFeatures" => "",
            "deletedFeatures" => "",
            "notice" => "",
            "security" => "",
            "futurePlans" => "",
            "note" => "",
        ];
    }
}

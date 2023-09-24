<?php

namespace ikepu_tp\LaravelVersioning\app\Console\Commands;

use Error;
use Illuminate\Console\Command;

class MakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'versioning:make
                            {--VT|version_type= : version type (major, minor, patch)}
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

    protected $versions;
    /**
     * Execute the console command.
     */
    public function handle()
    {
        dump($this->getVersions(), $this->generateReleaseNote());
    }

    protected function getVersions()
    {
        if ($this->versions) return $this->versions;

        $path = base_path("version.json");
        if (!file_exists($path)) {
            $this->error("Could not find `version.json` file.");
            return;
        }

        $file = file_get_contents($path);
        $this->versions = json_decode($file, true);
        return $this->versions;
    }

    protected function generateReleaseNote()
    {
        $newVersion = [
            "version" => $this->generateVersion($this->getVersionType()),
            "releaseDate" => $this->getReleaseDate(),
            "Author" => $this->getAuthors(),
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

        return $newVersion;
    }

    protected function getVersionType(): string|null
    {
        $version_type = $this->option("version_type");
        if ($this->option("patch")) $version_type = "patch";
        if ($this->option("minor")) $version_type = "minor";
        if ($this->option("major")) $version_type = "major";
        if (is_null($version_type)) {
            foreach (["major", "minor", "patch"] as $vt) {
                if (!$this->confirm("Do you want to increase `{$vt}`?")) continue;
                $version_type = $vt;
                break;
            }
        }
        return $version_type;
    }

    protected function generateVersion(string $version_type = null): string|false
    {
        if (!in_array($version_type, ["major", "minor", "patch"]))
            return $this->ask("What's next version?", "0.0.0");
        $versions = $this->getVersions();
        $prev_version = count($versions) ? $versions[count($versions) - 1] : ["version" => "0.0.0"];
        $splited_prev_version = explode('.', preg_replace("/[^0-9\.]/", "", $prev_version["version"]));
        switch ($version_type) {
            case 'major':
                $splited_prev_version[0] = (int)$splited_prev_version[0] + 1;
                break;
            case 'minor':
                if ($splited_prev_version[1]) {
                    $splited_prev_version[1] = (int)$splited_prev_version[1] + 1;
                } else {
                    $splited_prev_version[1] = 1;
                }
                break;
            case 'patch':
                if ($splited_prev_version[2]) {
                    $splited_prev_version[2] = (int)$splited_prev_version[2] + 1;
                } else {
                    $splited_prev_version[2] = 1;
                }
                break;
        }
        return implode(".", $splited_prev_version);
    }

    protected function getReleaseDate(): string
    {
        return $this->ask("When will you release?", now()->format('Y/m/d'));
    }

    protected function getAuthors(): array
    {
        $authors = [];
        $continue = true;
        do {
            $authors[] = $this->ask("What's author name?", "Unknown");
            if (!$this->confirm("Do you have authors else?")) $continue = false;
        } while ($continue);
        return $authors;
    }
}

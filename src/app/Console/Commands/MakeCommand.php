<?php

namespace ikepu_tp\LaravelVersioning\app\Console\Commands;

use Error;
use Exception;
use ikepu_tp\LaravelVersioning\app\Services\VersionFileService;
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
        if (!file_exists(base_path("versions"))) mkdir(base_path("versions"));
        $versions = $this->getVersions();
        $version = $this->generateReleaseNote();
        dump($version);
        if (!$this->confirm("Is this OK?", true)) return;
        VersionFileService::saveJson(
            base_path($this->version_path("{$version['version']}.json")),
            $version
        );
        $versions[] = [
            "version" => $version["version"],
            "path" => $this->version_path("{$version['version']}.json"),
        ];
        VersionFileService::saveVersions($versions);
        $this->info("Generated release note.");
        return;
    }

    protected function version_path(string $path): string
    {
        return "versions/{$path}";
    }

    protected function getVersions()
    {
        if ($this->versions) return $this->versions;

        try {
            $this->versions = VersionFileService::getVersions();
            return $this->versions;
        } catch (Exception $e) {
            $this->error("Could not find `version.json` file.");
        }
    }

    protected function generateReleaseNote()
    {
        $newVersion = [
            "version" => $this->generateVersion($this->getVersionType()),
            "releaseDate" => $this->getReleaseDate(),
            "createdDate" => now()->format('Y/m/d'),
            "authors" => $this->getAuthors(),
            "url" => $this->getUrl(),
            "description" => $this->getDescriptions(),
            "newFeatures" => $this->getNewFeatures(),
            "changedFeatures" => $this->getChangedFeatures(),
            "deletedFeatures" => $this->getDeletedFeatures(),
            "notice" => $this->getNotice(),
            "security" => $this->getSecurity(),
            "futurePlans" => $this->getFuture(),
            "note" => $this->getNote(),
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
                $splited_prev_version[1] = 0;
                $splited_prev_version[2] = 0;
                break;
            case 'minor':
                if ($splited_prev_version[1]) {
                    $splited_prev_version[1] = (int)$splited_prev_version[1] + 1;
                } else {
                    $splited_prev_version[1] = 1;
                }
                $splited_prev_version[2] = 0;
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

    protected function getAskArray(string|array $ask): array|null
    {
        if (is_string($ask)) $answers = $this->getAskArrayByStr($ask);
        if (is_array($ask)) $answers = $this->getAskArrayByAry($ask);
        return count($answers) ? $answers : null;
    }

    protected function getAskArrayByAry(array $asks): array
    {
        $answers = [];
        $continue = true;
        do {
            $answer = [];
            foreach ($asks as $key => $ask) {
                $res = $this->ask($ask, null);
                if ($res) $answer[$key] = $res;
            }
            if (empty($answer)) {
                $continue = false;
                break;
            }
            $answers[] = $answer;
            if (!$this->confirm("Do you have anything else?")) $continue = false;
        } while ($continue);
        return $answers;
    }
    protected function getAskArrayByStr(string $ask): array
    {
        $answers = [];
        $continue = true;
        do {
            $answer = $this->ask($ask, null);
            if (!is_null($answer)) {
                $answers[] = $answer;
            } else {
                $continue = false;
                break;
            }
            if (!$this->confirm("Do you have anything else?")) $continue = false;
        } while ($continue);
        return $answers;
    }

    protected function getAuthors(): array|null
    {
        if (in_array("author", config("versioning.except"))) return null;
        return $this->getAskArray([
            "name" => "What's author name?",
            "homepage" => "What's author homepage?",
            "email" => "What's author email?",
        ]);
    }

    protected function getUrl(): array|null
    {
        if (in_array("url", config("versioning.except"))) return null;
        return $this->getAskArray("What's links for release notes?");
    }

    protected function getDescriptions(): array|null
    {
        if (in_array("description", config("versioning.except"))) return null;
        return $this->getAskArray("What's description of changes, etc.? ");
    }

    protected function getNewFeatures(): array|null
    {
        if (in_array("newFeatures", config("versioning.except"))) return null;
        return $this->getAskArray("What's description of new features?");
    }

    protected function getChangedFeatures(): array|null
    {
        if (in_array("changedFeatures", config("versioning.except"))) return null;
        return $this->getAskArray("What's description of changed features?");
    }

    protected function getDeletedFeatures(): array|null
    {
        if (in_array("deletedFeatures", config("versioning.except"))) return null;
        return $this->getAskArray("What's description of deleted features?");
    }

    protected function getNotice(): array|null
    {
        if (in_array("notice", config("versioning.except"))) return null;
        return $this->getAskArray("What's notices and important information for users?");
    }

    protected function getSecurity(): array|null
    {
        if (in_array("security", config("versioning.except"))) return null;
        return $this->getAskArray("What's security-related information for users?");
    }

    protected function getFuture(): array|null
    {
        if (in_array("futurePlans", config("versioning.except"))) return null;
        return $this->getAskArray("What's future plans and changes?");
    }

    protected function getNote(): array|null
    {
        if (in_array("note", config("versioning.except"))) return null;
        return $this->getAskArray("What's notes?");
    }
}
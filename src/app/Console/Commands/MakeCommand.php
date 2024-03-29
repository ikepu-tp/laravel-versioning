<?php

namespace ikepu_tp\LaravelVersioning\app\Console\Commands;

use ikepu_tp\LaravelVersioning\app\Services\MakeFileService;
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
        $makeFileService = new MakeFileService;
        $makeFileService->generateReleaseNote(
            $makeFileService->generateVersion($this->getVersionType()),
            $this->getReleaseDate(),
            now()->format('Y/m/d'),
            $this->getAuthors(),
            $this->getUrl(),
            $this->getDescriptions(),
            $this->getNewFeatures(),
            $this->getChangedFeatures(),
            $this->getDeletedFeatures(),
            $this->getNotice(),
            $this->getSecurity(),
            $this->getFuture(),
            $this->getNote(),
        );
        $makeFileService->generate();
        dump($makeFileService->getNewVersion());
        $this->info("Generated release note.");
        return;
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

    protected function getVersions()
    {
        if ($this->versions) return $this->versions;

        $this->versions = VersionFileService::getVersions();
        return $this->versions;
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
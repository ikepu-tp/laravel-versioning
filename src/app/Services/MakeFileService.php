<?php

namespace ikepu_tp\LaravelVersioning\app\Services;

use Exception;

class MakeFileService extends Service
{
    protected $versions;
    protected $newVersion;

    /**
     * generate version file
     *
     * @return void
     */
    public function generate(): void
    {
        if (!$this->newVersion) throw new Exception("Undefined new version");
        if (!file_exists(base_path("versions"))) mkdir(base_path("versions"));
        $versions = $this->getVersions();
        VersionFileService::saveJson(
            base_path($this->version_path("{$this->newVersion['version']}.json")),
            $this->newVersion
        );
        $versions[] = [
            "version" => $this->newVersion["version"],
            "path" => $this->version_path("{$this->newVersion['version']}.json"),
        ];
        VersionFileService::saveVersions($versions);
        return;
    }

    public function update(): void
    {
        if (!$this->newVersion) throw new Exception("Undefined new version");
        VersionFileService::saveJson(
            base_path($this->version_path("{$this->newVersion['version']}.json")),
            $this->newVersion
        );
        return;
    }

    public function getNewVersion(): array
    {
        return $this->newVersion;
    }

    protected function version_path(string $path): string
    {
        return "versions/{$path}";
    }

    protected function getVersions()
    {
        if ($this->versions) return $this->versions;

        $this->versions = VersionFileService::getVersions();
        return $this->versions;
    }

    /**
     * generate release notes
     *
     * @param string $version
     * @param string|null $releaseDate
     * @param string|null $createdDate
     * @param array<int, {?name:string;?homepage:string;?email:string;}> $authors
     * @param array<int, string>|null $url
     * @param array<int, string>|null $description
     * @param array<int, string>|null $newFeatures
     * @param array<int, string>|null $changedFeatures
     * @param array<int, string>|null $deletedFeatures
     * @param array<int, string>|null $notice
     * @param array<int, string>|null $security
     * @param array<int, string>|null $futurePlans
     * @param array<int, string>|null $note
     * @return void
     */
    public function generateReleaseNote(
        string $version,
        string $releaseDate = null,
        string $createdDate = null,
        array $authors = null,
        array $url = null,
        array $description = null,
        array $newFeatures = null,
        array $changedFeatures = null,
        array $deletedFeatures = null,
        array $notice = null,
        array $security = null,
        array $futurePlans = null,
        array $note = null,
    ) {
        if (is_null($releaseDate)) $releaseDate = now()->format('Y/m/d');
        if (is_null($createdDate)) $createdDate = now()->format('Y/m/d');

        $this->newVersion = [
            "version" => $version,
            "releaseDate" => $releaseDate,
            "createdDate" => $createdDate,
            "authors" => $authors,
            "url" => $url,
            "description" => $description,
            "newFeatures" => $newFeatures,
            "changedFeatures" => $changedFeatures,
            "deletedFeatures" => $deletedFeatures,
            "notice" => $notice,
            "security" => $security,
            "futurePlans" => $futurePlans,
            "note" => $note,
        ];

        return $this->newVersion;
    }

    /**
     * generate a new version
     *
     * @param "major"|"minor"|"patch" $version_type
     * @param string|null $prev_version
     * @return string
     */
    public function generateVersion(string $version_type, string $prev_version = null): string
    {
        if (!in_array($version_type, ["major", "minor", "patch"])) throw new Exception("Invalid version type");

        if (is_null($prev_version)) {
            if ($this->newVersion && isset($this->newVersion["version"])) {
                $prev_version = $this->newVersion["version"];
            }
            if (empty($prev_version)) {
                $versions = $this->getVersions();
                $prev_version = count($versions) ? $versions[count($versions) - 1]["version"] :  "0.0.0";
            }
        }

        $splited_prev_version = explode('.', preg_replace("/[^0-9\.]/", "", $prev_version));

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

        $this->newVersion["version"] = implode(".", $splited_prev_version);
        return $this->newVersion["version"];
    }
}
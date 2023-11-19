<?php

namespace ikepu_tp\LaravelVersioning\app\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use Exception;
use ikepu_tp\LaravelVersioning\app\Services\VersionFileService;

class VersionController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return response()->view("LaravelVersioning::version", [
            "versions" => VersionFileService::getVersions(),
            "type" => in_array(
                config("versioning.list_view"),
                ["version-list", "version-with-detail"]
            ) ? config("versioning.list_view") : "version-list",
        ]);
    }

    public function show(Request $request, $version)
    {
        $json = null;
        try {
            $json = VersionFileService::getJson(base_path("versions/{$version}.json"));
        } catch (Exception $e) {
            $versions = VersionFileService::getVersions();
            foreach ($versions as $ver) {
                if ($ver["version"] === $version) {
                    $json = $ver;
                    break;
                }
            }
        }
        if (is_null($json)) abort(404, "Not Found");
        return response()->view("LaravelVersioning::version-show", [
            "version" => $json,
        ]);
    }
}
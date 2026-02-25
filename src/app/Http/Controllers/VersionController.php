<?php

namespace ikepu_tp\LaravelVersioning\app\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use Exception;
use ikepu_tp\LaravelVersioning\app\Services\VersionFileService;
use Inertia\Inertia;
use Inertia\Response;

class VersionController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        return Inertia::render('LaravelVersioning/Version/Index', [
            "versions" => VersionFileService::getVersions(),
        ]);
    }

    public function show(Request $request, $version): Response
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
        return Inertia::render('LaravelVersioning/Version/Show', [
            "version" => $json,
        ]);
    }
}

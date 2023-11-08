<?php

namespace ikepu_tp\LaravelVersioning\app\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
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
            "type" => "version-with-detail",
        ]);
    }

    public function show(Request $request, $version)
    {
        return response()->view("LaravelVersioning::version-show", []);
    }
}
<?php

namespace ikepu_tp\LaravelVersioning\app\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use DateTime;
use Exception;
use ikepu_tp\LaravelVersioning\app\Services\MakeFileService;
use ikepu_tp\LaravelVersioning\app\Services\VersionFileService;
use Inertia\Inertia;
use Inertia\Response;

class EditorController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        return Inertia::render('LaravelVersioning/Editor/Index', [
            "versions" => VersionFileService::getVersions(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('LaravelVersioning/Editor/Edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $makeFileService = new MakeFileService;
        $makeFileService->generateReleaseNote(
            $request->input("version", ""),
            $request->input("releaseDate"),
            $request->input("createdDate"),
            $request->input("authors"),
            $request->input("url"),
            $request->input("description"),
            $request->input("newFeatures"),
            $request->input("changedFeatures"),
            $request->input("deletedFeatures"),
            $request->input("notice"),
            $request->input("security"),
            $request->input("futurePlans"),
            $request->input("note"),
        );
        $makeFileService->generateVersion($request->input("version_type", "patch"));
        $makeFileService->generate();
        return redirect(route("version.editor.edit", ["editor" => $makeFileService->getNewVersion()["version"]]));
    }

    /**
     * Display the specified resource.
     */
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $version): Response
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
        if (!is_null($json["releaseDate"])) $json["releaseDate"] = (new DateTime($json["releaseDate"]))->format("Y-m-d");
        if (!is_null($json["createdDate"])) $json["createdDate"] = (new DateTime($json["createdDate"]))->format("Y-m-d");

        if (isset($json['Author'])) $json["authors"] = $json['Author'];
        if (is_string($json['authors']))
            $json["authors"] = [
                ["name" => $json['authors']]
            ];
        if (is_null($json["authors"])) $json["authors"] = [];
        if (is_string($json['url'])) $json['url'] = [$json['url']];
        if (is_null($json["url"])) $json["url"] = [];

        $json["description"] = $this->convertNullToArray($json["description"]);
        $json["newFeatures"] = $this->convertNullToArray($json["newFeatures"]);
        $json["changedFeatures"] = $this->convertNullToArray($json["changedFeatures"]);
        $json["deletedFeatures"] = $this->convertNullToArray($json["deletedFeatures"]);
        $json["notice"] = $this->convertNullToArray($json["notice"]);
        $json["security"] = $this->convertNullToArray($json["security"]);
        $json["futurePlans"] = $this->convertNullToArray($json["futurePlans"]);
        $json["note"] = $this->convertNullToArray($json["note"]);

        return Inertia::render('LaravelVersioning/Editor/Edit', [
            "version" => $json,
        ]);
    }

    public function convertNullToArray(null|array $value): array
    {
        return is_null($value) ? [] : $value;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $version)
    {
        $makeFileService = new MakeFileService;
        $makeFileService->generateReleaseNote(
            $version,
            $request->input("releaseDate"),
            $request->input("createdDate"),
            $request->input("authors"),
            $request->input("url"),
            $request->input("description"),
            $request->input("newFeatures"),
            $request->input("changedFeatures"),
            $request->input("deletedFeatures"),
            $request->input("notice"),
            $request->input("security"),
            $request->input("futurePlans"),
            $request->input("note"),
        );
        $makeFileService->update();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
}

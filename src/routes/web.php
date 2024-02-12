<?php

use ikepu_tp\LaravelVersioning\app\Http\Controllers\EditorController;
use ikepu_tp\LaravelVersioning\app\Http\Controllers\VersionController;
use Illuminate\Support\Facades\Route;

Route::group([
    "middleware" => config("versioning.web_middleware", []),
], function () {
    Route::get("version", [VersionController::class, "index"])->name("version.index");
    Route::get("version/{version}", [VersionController::class, "show"])->name("version.show");
});
Route::group([
    "middleware" => config("versioning.editor_web_middleware", []),
    "prefix" => config("versioning.editor_prefix", "versioning"),
], function () {
    Route::resource("editor", EditorController::class)->names("version.editor");
});
Route::group([
    "middleware" => config("versioning.api_middleware", [])
], function () {
});
Route::group([
    "middleware" => config("versioning.editor_api_middleware", []),
    "prefix" => config("versioning.editor_prefix", "versioning"),
], function () {
});
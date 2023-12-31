<?php

use ikepu_tp\LaravelVersioning\app\Http\Controllers\VersionController;
use Illuminate\Support\Facades\Route;

Route::group([], function () {
    Route::get("version", [VersionController::class, "index"])->name("version.index");
    Route::get("version/{version}", [VersionController::class, "show"])->name("version.show");
});
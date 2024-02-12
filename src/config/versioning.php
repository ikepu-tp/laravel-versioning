<?php

return [
    /**
     * ----------------------------------------------------------------
     * Web Route Middleware
     * ----------------------------------------------------------------
     */
    "web_middleware" => [
        "web",
    ],
    "editor_web_middleware" => [
        "web",
        \ikepu_tp\LaravelVersioning\app\Http\Middleware\VersioningEditorMiddleware::class,
    ],

    /**
     * ----------------------------------------------------------------
     * API Route Middleware
     * ----------------------------------------------------------------
     */
    "api_middleware" => [
        "api",
    ],
    "editor_api_middleware" => [
        "api",
        \ikepu_tp\LaravelVersioning\app\Http\Middleware\VersioningEditorMiddleware::class,
    ],

    /**
     * ----------------------------------------------------------------
     * Except keys
     * ----------------------------------------------------------------
     */
    "except" => [
        //"author",
        //"url",
        //"description",
        //"newFeatures",
        //"changedFeatures",
        //"deletedFeatures",
        //"notice",
        //"security",
        //"futurePlans",
        //"note",
    ],

    /**
     * ----------------------------------------------------------------
     * List View
     * ----------------------------------------------------------------
     * Please set "version-list" or "version-with-detail".
     */
    "list_view" => "version-list",
    //"list_view"=>"version-with-detail",

    /**
     * ----------------------------------------------------------------
     * Prefix on Editor Pages
     * ----------------------------------------------------------------
     */
    "editor_prefix" => "versioning",
];
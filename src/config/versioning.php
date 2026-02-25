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

    /**
     * ----------------------------------------------------------------
     * Editor Permission: User IDs
     * ----------------------------------------------------------------
     * Comma-separated list of user IDs allowed to access the editor.
     * Example: VERSIONING_EDITOR_USER_IDS=1,2,3
     */
    "editor_user_ids" => env("VERSIONING_EDITOR_USER_IDS", ""),

    /**
     * ----------------------------------------------------------------
     * Editor Permission: Emails
     * ----------------------------------------------------------------
     * Comma-separated list of emails allowed to access the editor.
     * Example: VERSIONING_EDITOR_EMAILS=admin@example.com,editor@example.com
     */
    "editor_emails" => env("VERSIONING_EDITOR_EMAILS", ""),
];
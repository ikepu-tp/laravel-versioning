<?php

namespace ikepu_tp\LaravelVersioning\app\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class VersioningEditorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$this->isAuthorized($request)) abort(401);
        return $next($request);
    }

    private function isAuthorized(Request $request): bool
    {
        if (App::isLocal()) return true;

        $user = $request->user();
        if (!$user) return false;

        $userIds = config('versioning.editor_user_ids', '');
        if (is_string($userIds)) {
            $userIds = array_filter(array_map('trim', explode(',', $userIds)));
        }
        if (!empty($userIds) && in_array((string)$user->id, array_map('strval', $userIds))) {
            return true;
        }

        $emails = config('versioning.editor_emails', '');
        if (is_string($emails)) {
            $emails = array_filter(array_map('trim', explode(',', $emails)));
        }
        if (!empty($emails) && in_array($user->email, $emails)) {
            return true;
        }

        return false;
    }
}
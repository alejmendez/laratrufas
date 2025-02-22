<?php

namespace Modules\Core\Traits;

use Modules\Core\Services\CacheService;

trait HasPermissionMiddleware
{
    protected function setupPermissionMiddleware()
    {
        $this->middleware(function ($request, $next) {
            $routeName = $request->route()->getName();
            $user = auth()->user();

            $userPermissions = CacheService::getUserPermissions($user);

            if (! $userPermissions->contains($routeName)) {
                abort(403);
            }

            return $next($request);
        });
    }
}

<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

use Modules\Core\Services\CacheService;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user();
        $userData = $user;
        if ($user) {
            $data = $user->toArray();

            $userData = [
                'id' => $user->id,
                'full_name' => $user->full_name,
                'avatar_url' => CacheService::getUserAvatar($user),
                'dni' => $user->dni,
                'email' => $user->email,
                'roles' => CacheService::getUserRoles($user),
                'permissions' => CacheService::getUserPermissions($user),
                'unread_notifications' => CacheService::getUserUnreadNotifications($user),
            ];
        }

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $userData,
            ],
        ];
    }
}

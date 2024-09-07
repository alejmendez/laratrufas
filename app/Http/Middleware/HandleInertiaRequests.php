<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Middleware;

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
                'avatar_url' => $user->avatar === null ? null : (Str::startsWith($user->avatar, 'http') ? $user->avatar : Storage::url($user->avatar)),
                'dni' => $user->dni,
                'email' => $user->email,
                'roles' => collect($user->getRoleNames())->map(fn ($role) => Str::slug($role)),
                'permissions' => $user->getAllPermissions()->pluck('name')->map(fn ($user) => Str::slug($user)),
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

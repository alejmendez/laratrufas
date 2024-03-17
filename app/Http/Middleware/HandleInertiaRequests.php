<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


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
    public function version(Request $request): string|null
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
            $userData = $user->toArray();
            $userData['full_name'] = $user->full_name;

            if ($user->avatar === null) {
                $userData['avatar_url'] = null;
            } else {
                $userData['avatar_url'] = Str::startsWith($user->avatar, 'http') ? $user->avatar : Storage::disk('avatars')->url($user->avatar);
            }
        }
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $userData,
            ],
        ];
    }
}

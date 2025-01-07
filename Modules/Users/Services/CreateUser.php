<?php

namespace Modules\Users\Services;

use Modules\Users\Models\User;
use Illuminate\Support\Facades\Hash;

use Modules\Core\Services\CacheService;

class CreateUser
{
    public static function call($data): User
    {
        $user = new User;
        $user->name = $data['name'];
        $user->last_name = $data['last_name'];
        $user->dni = $data['dni'];
        $user->email = $data['email'];
        $user->phone = $data['phone'];
        $user->avatar = $data['avatar'];
        $user->password = Hash::make($data['password']);
        $user->save();

        if ($data['role']) {
            $user->syncRoles([$data['role']]);
        }

        CacheService::clearUserCache($user);

        return $user;
    }
}

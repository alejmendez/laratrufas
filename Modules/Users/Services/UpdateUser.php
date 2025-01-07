<?php

namespace Modules\Users\Services;

use Modules\Users\Models\User;
use Modules\Core\Services\CacheService;

class UpdateUser
{
    public static function call($id, $data): User
    {
        $user = User::findOrFail($id);

        $user->name = $data['name'];
        $user->last_name = $data['last_name'];
        $user->dni = $data['dni'];
        $user->email = $data['email'];
        $user->phone = $data['phone'];

        if ($data['avatar']) {
            $user->avatar = $data['avatar'];
        }

        if ($data['avatarRemove'] === '1') {
            $user->avatar = null;
        }

        if ($data['password'] != '') {
            $user->password = Hash::make($data['password']);
        }

        if ($user->email !== $data['email']) {
            $user->email_verified_at = null;
        }

        $user->save();

        if ($data['role']) {
            $user->syncRoles([$data['role']]);
        }

        CacheService::clearUserCache($user);

        return $user;
    }
}

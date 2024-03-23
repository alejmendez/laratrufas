<?php

namespace App\Services\Users;

use App\Models\User;

class UpdateUser
{
    public static function call($id, $data): User
    {
        unset($data['id']);
        $user = User::findOrFail($id);

        if (!$data['avatar']) {
            unset($data['avatar']);
        }

        if ($data['avatarRemove'] === '1') {
            $data['avatar'] = null;
        }

        if ($data['password'] == '') {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        if ($user->email !== $data['email']) {
            $data['email_verified_at'] = null;
        }

        $user->update($data);
        $role = $data['role'] ?? null;
        self::assignRole($user, $role);

        return $user;
    }

    protected static function assignRole($user, $role)
    {
        if (!$role) {
            return;
        }

        $user->getRoleNames()
            ->filter(function ($name) use ($role) {
                return $role !== $name;
            })
            ->map(function ($name) use ($user) {
                $user->removeRole($name);
            });

        if (!$user->hasExactRoles($role)) {
            $user->assignRole($role);
        }
    }
}

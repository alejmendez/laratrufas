<?php

namespace App\Services\Users;

use App\Models\User;

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

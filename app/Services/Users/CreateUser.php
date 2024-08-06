<?php

namespace App\Services\Users;

use Illuminate\Support\Facades\Hash;
use App\Models\User;

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

        return $user;
    }
}

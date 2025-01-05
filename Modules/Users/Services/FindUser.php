<?php

namespace Modules\Users\Services;

use Modules\Users\Models\User;

class FindUser
{
    public static function call($id)
    {
        $user = User::with('roles')->findOrFail($id);

        return $user;
    }
}

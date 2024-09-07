<?php

namespace App\Services\Roles;

use Spatie\Permission\Models\Role;

class FindRole
{
    public static function call($id)
    {
        $role = Role::findOrFail($id);

        return $role;
    }
}

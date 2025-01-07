<?php

namespace Modules\Field\Services\Roles;

use Spatie\Permission\Models\Role;

class ListRole
{
    public static function call()
    {
        $roles = Role::all();

        return $roles;
    }
}

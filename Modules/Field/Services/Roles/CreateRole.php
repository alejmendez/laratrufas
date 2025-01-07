<?php

namespace Modules\Field\Services\Roles;

use Spatie\Permission\Models\Role;

class CreateRole
{
    public static function call($data): Role
    {
        $role = Role::create($data);

        return $role;
    }
}

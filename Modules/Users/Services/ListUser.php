<?php

namespace Modules\Users\Services;

use Modules\Core\Services\PrimevueDatatables;
use Modules\Users\Models\User;

class ListUser
{
    public static function call($params = [])
    {
        $searchableColumns = ['full_name', 'dni', 'phone', 'roles.name', 'email'];

        $query = User::query();

        $datatable = new PrimevueDatatables($params, $searchableColumns);
        $users = $datatable->of($query)->make();

        return $users;
    }
}

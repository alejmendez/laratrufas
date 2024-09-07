<?php

namespace App\Services\Users;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Services\Primevue\PrimevueDatatables;

class ListUser
{
    public static function call($params = [])
    {
        $searchableColumns = ['full_name', 'dni', 'phone', 'roles.name', 'email',];

        $query = User::query();

        $datatable = new PrimevueDatatables($params, $searchableColumns);
        $users = $datatable->of($query)->make();

        return $users;
    }
}

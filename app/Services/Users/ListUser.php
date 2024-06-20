<?php

namespace App\Services\Users;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Utils\Query;

class ListUser
{
    public static function call($order = '', $search = '')
    {
        $subquery = User::select(
                'users.id',
                DB::raw("CONCAT(users.name, ' ', users.last_name) as name"),
                'users.dni',
                'users.phone',
                DB::raw("STRING_AGG(DISTINCT roles.name, ', ') as roles_name"),
                'users.email'
            )
            ->leftJoin('model_has_roles', function($join) {
                $join->on('model_has_roles.model_id', '=', 'users.id');
                $join->on('model_has_roles.model_type', '=', DB::raw("'App\Models\User'"));
            })
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->groupBy(
                'users.id',
                'users.name',
                'users.last_name',
                'users.dni',
                'users.phone',
                'users.email'
            );

        $users = DB::table(DB::raw("({$subquery->toSql()}) as users"));
        Query::order($users, $order);

        if ($search) {
            $users->whereAny([
                'name',
                'last_name',
                'dni',
                'phone',
                'email',
                'roles_name',
            ], 'ILIKE', "%{$search}%");
        }

        return $users;
    }
}

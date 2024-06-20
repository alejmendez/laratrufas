<?php

namespace App\Services\Dogs;

use Illuminate\Support\Facades\DB;
use App\Models\Dog;

class ListDog
{
    public static function call($order = '', $search = '')
    {
        $dogs = Dog::leftJoin('users', 'dogs.couple_id', '=', 'users.id')
            ->leftJoin('quarters', 'dogs.quarter_id', '=', 'quarters.id')
            ->select(
                'dogs.id',
                'dogs.name',
                'dogs.birthdate',
                DB::raw("DATE_PART('year', AGE(dogs.birthdate)) as age"),
                'quarters.name as quarter_name',
                'gender',
                'breed',
                'veterinary',
                DB::raw("CONCAT(users.name, ' ', users.last_name) as couple_name"),
            )
            ->order($order);

        if ($search) {
            $dogs->whereAny([
                'dogs.name',
                'quarters.name',
                'gender',
                'breed',
                'veterinary',
                'users.name',
                'users.last_name',
            ], 'ILIKE', "%{$search}%");
        }

        return $dogs;
    }
}

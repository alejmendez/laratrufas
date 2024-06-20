<?php

namespace App\Services\Dogs;

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
                'birthdate',
                'quarters.name as quarter_name',
                'gender',
                'breed',
                'veterinary',
                'users.name as couple_name'
            )
            ->order($order);

        if ($search) {
            $dogs->whereAny([
                'dogs.name',
                'quarters.name',
                'gender',
                'breed',
                // 'age',
                'veterinary',
                'users.name',
            ], 'ILIKE', "%{$search}%");
        }

        return $dogs;
    }
}

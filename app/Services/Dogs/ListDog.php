<?php

namespace App\Services\Dogs;

use App\Models\Dog;

class ListDog
{
    public static function call($order = '', $search = '')
    {
        $dogs = Dog::with('quarter.field', 'vaccines')->order($order)->search($search);

        return $dogs;
    }
}

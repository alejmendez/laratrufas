<?php

namespace App\Services\Dogs;

use App\Models\Dog;

class FindDog
{
    public static function call($id)
    {
        $dog = Dog::findOrFail($id);

        return $dog;
    }
}

<?php

namespace App\Services\Dogs;

use App\Models\Dog;

class CreateDog
{
    public static function call($data): Dog
    {
        $dog = Dog::create($data);
        return $dog;
    }
}

<?php

namespace App\Services\Dogs;

use App\Models\Dog;

class UpdateDog
{
    public static function call($id, $data): Dog
    {
        unset($data['id']);
        $dog = Dog::findOrFail($id);

        $dog->update($data);

        return $dog;
    }
}

<?php

namespace App\Services\Dogs;

use App\Models\Dog;

class UpdateDog
{
    public static function call($id, $data): Dog
    {
        unset($data['id']);
        $dog = Dog::findOrFail($id);

        if (!$data['avatar']) {
            unset($data['avatar']);
        }

        if ($data['avatarRemove'] === '1') {
            $data['avatar'] = null;
        }

        $dog->update($data);

        return $dog;
    }
}

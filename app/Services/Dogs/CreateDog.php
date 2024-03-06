<?php

namespace App\Services\Dogs;

use App\Models\Dog;
use App\Models\DogVaccine;

class CreateDog
{
    public static function call($data): Dog
    {
        $vaccines = $data['vaccines'];
        unset($data['vaccines']);

        $dog = Dog::create($data);
        foreach ($vaccines as $vaccine) {
            $vaccine['dog_id'] = $dog->id;
            DogVaccine::create($vaccine);
        }
        return $dog;
    }
}

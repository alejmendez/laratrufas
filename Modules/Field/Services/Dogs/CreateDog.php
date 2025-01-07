<?php

namespace Modules\Field\Services\Dogs;

use Modules\Field\Models\Dog;
use Modules\Field\Models\DogVaccine;

class CreateDog
{
    public static function call($data): Dog
    {
        $dog = new Dog;
        $dog->name = $data['name'];
        $dog->breed = $data['breed'];
        $dog->gender = $data['gender']['value'];
        $dog->birthdate = $data['birthdate'];
        $dog->veterinary = $data['veterinary'];
        $dog->quarter_id = $data['quarter_id']['value'];
        $dog->couple_id = $data['couple_id']['value'];
        $dog->avatar = $data['avatar'];

        $dog->save();

        foreach ($data['vaccines'] as $vaccine) {
            $dog_vaccine = new DogVaccine;
            $dog_vaccine->name = $vaccine['name'];
            $dog_vaccine->date = $vaccine['date'];
            $dog_vaccine->code = $vaccine['code'];
            $dog_vaccine->dog_id = $dog->id;
            $dog_vaccine->save();
        }

        return $dog;
    }
}

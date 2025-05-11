<?php

namespace Modules\Fields\Services\Dogs;

use Modules\Fields\Models\Dog;
use Modules\Fields\Models\DogVaccine;

class UpdateDog
{
    public static function call($id, $data): Dog
    {
        $vaccines = $data['vaccines'] ?? [];

        $dog = Dog::findOrFail($id);
        $dog->name = $data['name'];
        $dog->breed = $data['breed'];
        $dog->gender = $data['gender']['value'];
        $dog->birthdate = $data['birthdate'];
        $dog->veterinary = $data['veterinary'];
        $dog->quarter_id = $data['quarter_id']['value'];
        $dog->couple_id = $data['couple_id']['value'];

        if ($data['avatar']) {
            $dog->avatar = $data['avatar'];
        }

        if ($data['avatarRemove'] === '1') {
            $dog->avatar = null;
        }

        $dog->save();

        self::save_vaccines($dog, $vaccines);

        return $dog;
    }

    protected static function save_vaccines($dog, $data)
    {
        $vaccines = collect($data);

        $idVaccines = $dog->vaccines()->pluck('id');
        $idVaccinesToDestroy = $idVaccines->filter(function ($id, int $key) use ($vaccines) {
            return ! $vaccines->firstWhere('id', $id);
        })->toArray();

        DogVaccine::destroy($idVaccinesToDestroy);
        foreach ($vaccines as $vaccine) {
            if ($vaccine['name'] == null && $vaccine['date'] == null && $vaccine['code'] == null) {
                continue;
            }
            $dog_vaccine = DogVaccine::firstOrNew(['id' => $vaccine['id']]);
            $dog_vaccine->name = $vaccine['name'];
            $dog_vaccine->date = $vaccine['date'];
            $dog_vaccine->code = $vaccine['code'];
            $dog_vaccine->save();
        }
    }
}

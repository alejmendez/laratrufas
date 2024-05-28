<?php

namespace App\Services\Dogs;

use App\Models\Dog;
use App\Models\DogVaccine;

class UpdateDog
{
    public static function call($id, $data): Dog
    {
        $vaccines = $data['vaccines'] ?? [];
        $data = self::clean_data($data);

        $dog = Dog::findOrFail($id);
        $dog->update($data);

        self::save_vaccines($vaccines);

        return $dog;
    }

    protected static function clean_data($data) {
        unset($data['id']);
        unset($data['vaccines']);

        if (!$data['avatar']) {
            unset($data['avatar']);
        }

        if ($data['avatarRemove'] === '1') {
            $data['avatar'] = null;
        }

        return $data;
    }

    protected static function save_vaccines($data) {
        if (count($data) === 0) {
            return;
        }

        $vaccines = collect($data);

        $idVaccines = $dog->vaccines()->pluck('id');
        $idVaccinesToDestroy = $idVaccines->filter(function ($id, int $key) use ($vaccines) {
            return !$vaccines->firstWhere('id', $id);
        })->toArray();

        DogVaccine::destroy($idVaccinesToDestroy);
        foreach ($vaccines as $vaccine) {
            $vaccine['dog_id'] = $dog->id;
            if ($vaccine['id'] === null) {
                DogVaccine::create($vaccine);
            } else {
                DogVaccine::where('id', $vaccine['id'])->update($vaccine);
            }
        }
    }
}

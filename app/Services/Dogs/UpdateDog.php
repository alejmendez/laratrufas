<?php

namespace App\Services\Dogs;

use App\Models\Dog;
use App\Models\DogVaccine;

class UpdateDog
{
    public static function call($id, $data): Dog
    {
        $vaccines = collect($data['vaccines']);
        unset($data['id']);
        unset($data['vaccine']);

        $dog = Dog::findOrFail($id);
        $idVaccines = $dog->vaccines()->pluck('id');
        $idVaccinesToDestroy = $idVaccines->filter(function ($id, int $key) use ($vaccines) {
            return !$vaccines->firstWhere('id', $id);
        })->toArray();

        if (!$data['avatar']) {
            unset($data['avatar']);
        }

        if ($data['avatarRemove'] === '1') {
            $data['avatar'] = null;
        }

        $dog->update($data);
        DogVaccine::destroy($idVaccinesToDestroy);
        foreach ($vaccines as $vaccine) {
            $vaccine['dog_id'] = $dog->id;
            if ($vaccine['id'] === null) {
                DogVaccine::create($vaccine);
            } else {
                DogVaccine::where('id', $vaccine['id'])->update($vaccine);
            }
        }

        return $dog;
    }
}

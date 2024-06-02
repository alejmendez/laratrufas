<?php

namespace App\Services\Equipments;

use App\Models\Equipment;

class CreateEquipment
{
    public static function call($data): Equipment
    {
        $equipment = Equipment::create($data);
        return $equipment;
    }
}

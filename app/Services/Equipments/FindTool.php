<?php

namespace App\Services\Equipments;

use App\Models\Equipment;

class FindEquipment
{
    public static function call($id)
    {
        $equipment = Equipment::findOrFail($id);

        return $equipment;
    }
}

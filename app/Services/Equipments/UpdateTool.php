<?php

namespace App\Services\Equipments;

use App\Models\Equipment;
use App\Models\EquipmentVaccine;

class UpdateEquipment
{
    public static function call($id, $data): Equipment
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->update($data);

        return $equipment;
    }
}

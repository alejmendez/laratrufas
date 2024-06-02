<?php

namespace App\Services\Equipments;

use App\Models\Equipment;

class DeleteEquipment
{
    public static function call($id): void
    {
        Equipment::destroy($id);
    }
}

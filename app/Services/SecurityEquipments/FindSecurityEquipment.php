<?php

namespace App\Services\SecurityEquipments;

use App\Models\SecurityEquipment;

class FindSecurityEquipment
{
    public static function call($id)
    {
        $security_equipment = SecurityEquipment::findOrFail($id);

        return $security_equipment;
    }
}

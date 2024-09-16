<?php

namespace App\Services\SecurityEquipments;

use App\Models\SecurityEquipment;

class DeleteSecurityEquipment
{
    public static function call($id): void
    {
        SecurityEquipment::destroy($id);
    }
}

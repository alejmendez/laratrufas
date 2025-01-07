<?php

namespace Modules\Field\Services\SecurityEquipments;

use Modules\Field\Models\SecurityEquipment;

class FindSecurityEquipment
{
    public static function call($id)
    {
        $security_equipment = SecurityEquipment::findOrFail($id);

        return $security_equipment;
    }
}

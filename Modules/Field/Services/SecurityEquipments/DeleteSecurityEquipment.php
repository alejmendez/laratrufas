<?php

namespace Modules\Field\Services\SecurityEquipments;

use Modules\Field\Models\SecurityEquipment;

class DeleteSecurityEquipment
{
    public static function call($id): void
    {
        SecurityEquipment::destroy($id);
    }
}

<?php

namespace App\Services\Equipments;

use App\Models\Equipment;

class ListEquipment
{
    public static function call($order = '', $search = '')
    {
        $equipments = Equipment::order($order)->search($search);

        return $equipments;
    }
}

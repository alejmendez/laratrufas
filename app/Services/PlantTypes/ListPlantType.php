<?php

namespace App\Services\PlantTypes;

use App\Models\PlantType;

class ListPlantType
{
    public static function call($order = '', $search = '')
    {
        $types = PlantType::order($order)->search($search);

        return $types;
    }
}

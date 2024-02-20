<?php

namespace App\Services\PlantTypes;

use App\Models\PlantType;

class FindPlantType
{
    public static function call($id)
    {
        $type = PlantType::findOrFail($id);

        return $type;
    }
}

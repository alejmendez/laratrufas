<?php

namespace App\Services\PlantTypes;

use App\Models\PlantType;

class CreatePlantType
{
    public static function call($data): PlantType
    {
        $type = PlantType::create($data);
        return $type;
    }
}

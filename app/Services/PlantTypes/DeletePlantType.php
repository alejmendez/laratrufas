<?php

namespace App\Services\PlantTypes;

use App\Models\PlantType;

class DeletePlantType
{
    public static function call($id): void
    {
        PlantType::destroy($id);
    }
}

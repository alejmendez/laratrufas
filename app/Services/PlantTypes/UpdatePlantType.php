<?php

namespace App\Services\PlantTypes;

use App\Models\PlantType;

class UpdatePlantType
{
    public static function call($id, $data): PlantType
    {
        unset($data['id']);
        $type = PlantType::findOrFail($id);
        $type->update($data);

        return $type;
    }
}

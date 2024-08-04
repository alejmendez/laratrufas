<?php

namespace App\Services\PlantTypes;

use App\Models\PlantType;

class UpdatePlantType
{
    public static function call($id, $name): PlantType
    {
        $slug = Str::slug($name);

        $type = PlantType::findOrFail($id);
        $type->name = $name;
        $type->slug = $slug;
        $type->save();

        return $type;
    }
}

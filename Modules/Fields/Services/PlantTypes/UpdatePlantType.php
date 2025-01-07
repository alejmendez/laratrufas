<?php

namespace Modules\Fields\Services\PlantTypes;

use Modules\Fields\Models\PlantType;

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

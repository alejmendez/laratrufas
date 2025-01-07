<?php

namespace Modules\Field\Services\PlantTypes;

use Modules\Field\Models\PlantType;

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

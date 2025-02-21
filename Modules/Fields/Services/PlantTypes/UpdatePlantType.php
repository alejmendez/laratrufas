<?php

namespace Modules\Fields\Services\PlantTypes;

use Modules\Fields\Models\PlantType;
use Illuminate\Support\Str;

class UpdatePlantType
{
    public static function call($id, $data): PlantType
    {
        $slug = Str::slug($data['name']);

        $type = PlantType::findOrFail($id);
        $type->name = $data['name'];
        $type->slug = $slug;
        $type->save();

        return $type;
    }
}

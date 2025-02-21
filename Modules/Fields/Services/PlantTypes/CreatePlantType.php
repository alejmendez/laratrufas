<?php

namespace Modules\Fields\Services\PlantTypes;

use Modules\Fields\Models\PlantType;
use Illuminate\Support\Str;

class CreatePlantType
{
    public static function call($data): PlantType
    {
        $slug = Str::slug($data['name']);
        $type = PlantType::where('slug', $slug)->first();
        if (!$type) {
            $type = new PlantType;
            $type->name = $data['name'];
            $type->slug = $slug;
            $type->save();
        }

        return $type;
    }
}

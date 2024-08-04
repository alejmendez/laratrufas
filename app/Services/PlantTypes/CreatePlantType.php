<?php

namespace App\Services\PlantTypes;

use Illuminate\Support\Str;

use App\Models\PlantType;

class CreatePlantType
{
    public static function call($name): PlantType
    {
        $slug = Str::slug($name);
        $type = PlantType::where('slug', $slug)->first();
        if (!$type) {
            $type = new PlantType;
            $type->name = $name;
            $type->slug = $slug;
            $type->save();
        }
        return $type;
    }
}

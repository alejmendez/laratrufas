<?php

namespace App\Services\PlantTypes;

use App\Models\PlantType;
use Illuminate\Support\Str;

class CreatePlantType
{
    public static function call($name): PlantType
    {
        $slug = Str::slug($name);
        $type = PlantType::where('slug', $slug)->first();
        if (! $type) {
            $type = new PlantType;
            $type->name = $name;
            $type->slug = $slug;
            $type->save();
        }

        return $type;
    }
}

<?php

namespace Modules\Field\Services\PlantTypes;

use Modules\Field\Models\PlantType;

class FindPlantType
{
    public static function call($id)
    {
        $type = PlantType::findOrFail($id);

        return $type;
    }
}

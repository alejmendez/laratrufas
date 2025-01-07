<?php

namespace Modules\Field\Services\PlantTypes;

use Modules\Field\Models\PlantType;

class DeletePlantType
{
    public static function call($id): void
    {
        PlantType::destroy($id);
    }
}

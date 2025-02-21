<?php

namespace Modules\Fields\Services\PlantTypes;

use Modules\Fields\Models\PlantType;
use Modules\Core\Services\PrimevueDatatables;

class ListPlantType
{
    public static function call($params = [])
    {
        $searchableColumns = ['name', 'slug'];

        $query = PlantType::query();

        $datatable = new PrimevueDatatables($params, $searchableColumns);
        $plant_types = $datatable->of($query)->make();

        return $plant_types;
    }
}

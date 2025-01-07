<?php

namespace Modules\Field\Services\Plants;

use Modules\Field\Models\Plant;
use Modules\Core\Services\PrimevueDatatables;

class ListPlant
{
    public static function call($params = [])
    {
        $searchableColumns = ['plants.code', 'quarter.name', 'quarter.field.name', 'plant_type.name', 'plants.age', 'quarter.responsible.full_name'];

        $query = Plant::query();

        $datatable = new PrimevueDatatables($params, $searchableColumns);
        $plants = $datatable->of($query)->make();

        return $plants;
    }
}

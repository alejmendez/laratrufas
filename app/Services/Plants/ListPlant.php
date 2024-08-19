<?php

namespace App\Services\Plants;

use Illuminate\Support\Facades\DB;
use App\Models\Plant;
use App\Services\Primevue\PrimevueDatatables;

class ListPlant
{
    public static function call($params = [])
    {
        $searchableColumns = ['plants.code', 'quarter.name', 'quarter.field.name', 'plant_type.name', 'plants.age', 'quarter.responsible.name', 'quarter.responsible.last_name',];

        $query = Plant::query();

        $datatable = new PrimevueDatatables($params, $searchableColumns);
        $plants = $datatable->of($query)->make();

        return $plants;
    }
}

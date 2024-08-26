<?php

namespace App\Services\Harvests;


use Illuminate\Support\Facades\DB;

use App\Models\Harvest;
use App\Services\Primevue\PrimevueDatatables;

class ListHarvest
{
    public static function call($params = [])
    {
        $query = Harvest::with('details.plant.quarter.field', 'farmer');

        $searchableColumns = ['date', 'batch', 'details.plant.quarter.field.name', 'details.plant.quarter.name', 'farmer.name', 'farmer.last_name'];
        $datatable = new PrimevueDatatables($params, $searchableColumns);
        $harvests = $datatable->of($query)->make();

        return $harvests;
    }
}

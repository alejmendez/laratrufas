<?php

namespace App\Services\Harvests;

use App\Models\Harvest;
use App\Services\Primevue\PrimevueDatatables;

class ListHarvest
{
    public static function call($params = [])
    {
        $query = Harvest::with('details.plant.quarter.field', 'farmer');

        $searchableColumns = ['year', 'batch', 'details.plant.quarter.field.name', 'details.plant.quarter.name', 'farmer.full_name'];
        $datatable = new PrimevueDatatables($params, $searchableColumns);
        $harvests = $datatable->of($query)->make();

        return $harvests;
    }
}

<?php

namespace App\Services\Liquidations;

use App\Models\Liquidation;
use App\Services\Primevue\PrimevueDatatables;

class ListLiquidation
{
    public static function call($params = [])
    {
        $searchableColumns = ['Liquidation_number', 'delivery_date', 'importer.name'];

        $query = Liquidation::query();

        $datatable = new PrimevueDatatables($params, $searchableColumns);
        $liquidations = $datatable->of($query)->make();

        return $liquidations;
    }
}

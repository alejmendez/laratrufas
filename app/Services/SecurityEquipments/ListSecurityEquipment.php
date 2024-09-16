<?php

namespace App\Services\SecurityEquipments;

use App\Models\SecurityEquipment;
use App\Services\Primevue\PrimevueDatatables;

class ListSecurityEquipment
{
    public static function call($params = [])
    {
        $searchableColumns = ['name', 'purchase_date', 'last_maintenance', 'purchase_location', 'contact'];

        $query = SecurityEquipment::query();

        $datatable = new PrimevueDatatables($params, $searchableColumns);
        $plants = $datatable->of($query)->make();

        return $plants;
    }
}

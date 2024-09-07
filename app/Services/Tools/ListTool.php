<?php

namespace App\Services\Tools;

use App\Models\Tool;
use App\Services\Primevue\PrimevueDatatables;

class ListTool
{
    public static function call($params = [])
    {
        $searchableColumns = ['name', 'purchase_date', 'last_maintenance', 'purchase_location', 'contact'];

        $query = Tool::query();

        $datatable = new PrimevueDatatables($params, $searchableColumns);
        $plants = $datatable->of($query)->make();

        return $plants;
    }
}

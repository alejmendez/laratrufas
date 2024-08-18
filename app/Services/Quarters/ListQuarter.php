<?php

namespace App\Services\Quarters;

use App\Models\Quarter;
use App\Services\Primevue\PrimevueDatatables;

class ListQuarter
{
    public static function call($params = [])
    {
        $query = Quarter::leftJoin('fields', 'quarters.field_id', '=', 'fields.id')
            ->select('quarters.id', 'quarters.name', 'fields.name as field_name', 'quarters.area')
            ->withCount('plants');
        $searchableColumns = ['quarters.name', 'field.name', 'quarters.area'];
        $datatable = new PrimevueDatatables($params, $searchableColumns);
        $quarters = $datatable->of($query)->make();

        return $quarters;
    }
}

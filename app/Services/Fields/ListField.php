<?php

namespace App\Services\Fields;

use App\Models\Field;
use App\Services\Primevue\PrimevueDatatables;

class ListField
{
    public static function call($params = [])
    {
        $query = Field::select('id', 'name', 'location', 'size')->withCount('plants');
        $searchableColumns = ['name', 'location', 'size'];
        $datatable = new PrimevueDatatables($params, $searchableColumns);
        $fields = $datatable->of($query)->make();

        return $fields;
    }
}

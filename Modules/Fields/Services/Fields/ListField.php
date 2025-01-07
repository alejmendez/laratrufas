<?php

namespace Modules\Fields\Services\Fields;

use Modules\Fields\Models\Field;
use Modules\Core\Services\PrimevueDatatables;

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

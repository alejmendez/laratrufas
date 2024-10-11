<?php

namespace App\Services\Graphs;

use Illuminate\Support\Str;

class GraphData
{
    public static function call($id, $type, $filters)
    {
        $typeStr = Str::of($type);

        if ($typeStr->startsWith('field-')) {
            return GraphDataField::call($id, $type, $filters);
        } elseif ($typeStr->startsWith('quarter-')) {
            return GraphDataField::call($id, $type, $filters);
        }
    }
}

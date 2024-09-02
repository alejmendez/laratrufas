<?php

namespace App\Services\Batches;

use Illuminate\Support\Facades\DB;
use App\Models\Batch;
use App\Services\Primevue\PrimevueDatatables;

class ListBatch
{
    public static function call($params = [])
    {
        $searchableColumns = ['batch_number', 'delivery_date', 'importer.name',];

        $query = Batch::query();

        $datatable = new PrimevueDatatables($params, $searchableColumns);
        $batches = $datatable->of($query)->make();

        return $batches;
    }
}

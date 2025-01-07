<?php

namespace Modules\Field\Services\Batches;

use Modules\Field\Models\Batch;
use Modules\Core\Services\PrimevueDatatables;

class ListBatch
{
    public static function call($params = [])
    {
        $searchableColumns = ['batch_number', 'delivery_date', 'importer.name'];

        $query = Batch::query();

        $datatable = new PrimevueDatatables($params, $searchableColumns);
        $batches = $datatable->of($query)->make();

        return $batches;
    }
}

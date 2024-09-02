<?php

namespace App\Services\Batches;

use App\Models\Batch;

class FindBatch
{
    public static function call($id)
    {
        $batch = Batch::findOrFail($id);

        return $batch;
    }
}

<?php

namespace App\Services\Batches;

use App\Models\Batch;

class DeleteBatch
{
    public static function call($id): void
    {
        Batch::destroy($id);
    }
}

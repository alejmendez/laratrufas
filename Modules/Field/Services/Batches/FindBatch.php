<?php

namespace Modules\Field\Services\Batches;

use Modules\Field\Models\Batch;

class FindBatch
{
    public static function call($id)
    {
        $batch = Batch::findOrFail($id);

        return $batch;
    }
}

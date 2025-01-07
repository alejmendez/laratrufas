<?php

namespace Modules\Field\Services\Batches;

use Modules\Field\Models\Batch;

class DeleteBatch
{
    public static function call($id): void
    {
        Batch::destroy($id);
    }
}

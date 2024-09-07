<?php

namespace App\Services\Batches;

use App\Models\Batch;

class UpdateBatch
{
    public static function call($id, $data): Batch
    {
        $batch = Batch::findOrFail($id);
        $batch->batch_number = $data['batch_number'];
        $batch->delivery_date = $data['delivery_date'];
        $batch->importer_id = $data['importer_id']['value'];
        $batch->save();

        $harvests_ids = collect($data['harvests'] ?? [])->map(fn ($q) => $q['value'])->toArray();
        $batch->harvests()->sync($harvests_ids);

        return $batch;
    }
}

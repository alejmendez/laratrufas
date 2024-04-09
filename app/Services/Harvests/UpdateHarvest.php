<?php

namespace App\Services\Harvests;

use App\Models\Harvest;
use App\Models\HarvestDetail;

class UpdateHarvest
{
    public static function call($id, $data): Harvest
    {
        unset($data['id']);

        $harvest = Harvest::findOrFail($id);
        $harvest->quarters()->sync($data['quarter_ids']);

        $details = collect($data['details']);
        unset($data['details']);

        $idDetails = $harvest->details()->pluck('id');
        $idDetailsToDestroy = $idDetails->filter(function ($id, int $key) use ($details) {
            return !$details->firstWhere('id', $id);
        })->toArray();

        $harvest->update($data);
        HarvestDetail::destroy($idDetailsToDestroy);
        foreach ($details as $detail) {
            $detail['harvest_id'] = $harvest->id;
            if ($detail['id'] === null) {
                HarvestDetail::create($detail);
            } else {
                HarvestDetail::where('id', $detail['id'])->update($detail);
            }
        }

        return $harvest;
    }
}

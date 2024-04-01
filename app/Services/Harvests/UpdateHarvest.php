<?php

namespace App\Services\Harvests;

use App\Models\Harvest;
use App\Models\HarvestDetail;

class UpdateHarvest
{
    public static function call($id, $data): Harvest
    {
        $details = collect($data['details']);
        unset($data['id']);
        unset($data['details']);

        $harvest = Harvest::findOrFail($id);
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

<?php

namespace App\Services\HarvestDetailss;

use App\Models\HarvestDetails;
use App\Models\HarvestDetailsDetail;

class UpdateHarvestDetails
{
    public static function call($id, $data): HarvestDetails
    {
        unset($data['id']);

        $harvest = HarvestDetails::findOrFail($id);
        $harvest->quarters()->sync($data['quarter_ids']);

        $details = collect($data['details']);
        unset($data['details']);

        $idDetails = $harvest->details()->pluck('id');
        $idDetailsToDestroy = $idDetails->filter(function ($id, int $key) use ($details) {
            return !$details->firstWhere('id', $id);
        })->toArray();

        $harvest->update($data);
        HarvestDetailsDetail::destroy($idDetailsToDestroy);
        foreach ($details as $detail) {
            $detail['harvest_id'] = $harvest->id;
            if ($detail['id'] === null) {
                HarvestDetailsDetail::create($detail);
            } else {
                HarvestDetailsDetail::where('id', $detail['id'])->update($detail);
            }
        }

        return $harvest;
    }
}

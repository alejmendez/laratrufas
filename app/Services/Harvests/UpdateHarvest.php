<?php

namespace App\Services\Harvests;

use App\Models\Plant;
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
        \Debugbar::info($details);
        foreach ($details as $detail) {
            $plant = Plant::where('code', $detail['plant_code'])->first();
            \Debugbar::info([
                'code' => $detail['plant_code'],
                'plant' => $plant,
            ]);
            if (!$plant) {
                continue;
            }

            $detail['harvest_id'] = $harvest->id;
            $detail['plant_id'] = $plant->id;
            if ($detail['id'] === null) {
                \Debugbar::info('create');
                HarvestDetail::create($detail);
            } else {
                \Debugbar::info('update');
                HarvestDetail::where('id', $detail['id'])->update($detail);
            }
        }

        return $harvest;
    }
}

<?php

namespace App\Services\Harvests;

use App\Models\Plant;
use App\Models\Harvest;
use App\Models\HarvestDetail;
use App\Services\Plants\FindPlantByCode;

use Illuminate\Support\Str;

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
            $plant = FindPlantByCode::call($detail['plant_code']);
            if (!$plant) {
                continue;
            }

            $detail['harvest_id'] = $harvest->id;
            $detail['plant_id'] = $plant->id;
            $detail['quality'] = Str::slug($detail['quality']);
            if ($detail['id'] === null) {
                HarvestDetail::create($detail);
            } else {
                HarvestDetail::where('id', $detail['id'])->update($detail);
            }
        }

        return $harvest;
    }
}

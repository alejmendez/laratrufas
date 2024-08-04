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
        $harvest = Harvest::findOrFail($id);

        $harvest->date = $date['date'];
        $harvest->batch = strtoupper($data['batch']);
        $harvest->dog_id = $date['dog_id']['value'];
        $harvest->farmer_id = $date['farmer_id']['value'];
        $harvest->assistant_id = $date['assistant_id']['value'];
        $harvest->save();

        $harvest->quarters()->sync($data['quarter_ids']);

        $details = collect($data['details']);

        $idDetails = $harvest->details()->pluck('id');
        $idDetailsToDestroy = $idDetails->filter(function ($id, int $key) use ($details) {
            return !$details->firstWhere('id', $id);
        })->toArray();

        HarvestDetail::destroy($idDetailsToDestroy);

        foreach ($details as $detail) {
            $plant = FindPlantByCode::call($detail['plant_code']);
            if (!$plant) {
                continue;
            }

            $harvest_detail = HarvestDetail::firstOrNew('id', $detail['id']);

            $harvest_detail->harvest_id = $harvest->id;
            $harvest_detail->plant_id = $plant->id;
            $harvest_detail->quality = Str::slug($detail['quality']);
            $harvest_detail->quality = $detail['weight'];
            $harvest_detail->save();
        }

        return $harvest;
    }
}

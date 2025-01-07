<?php

namespace Modules\Fields\Services\Harvests;

use Modules\Fields\Models\Harvest;
use Modules\Fields\Models\HarvestDetail;
use Modules\Fields\Services\Plants\FindPlantByCode;
use Illuminate\Support\Str;

class UpdateHarvest
{
    public static function call($id, $data): Harvest
    {
        $harvest = Harvest::findOrFail($id);

        $harvest->date = $data['date'];
        $harvest->batch = strtoupper($data['batch']);
        $harvest->dog_id = $data['dog_id']['value'];
        $harvest->farmer_id = $data['farmer_id']['value'];
        $harvest->assistant_id = $data['assistant_id']['value'];
        $harvest->save();

        $quarter_ids = [];
        foreach ($data['quarter_ids'] as $option) {
            $quarter_ids[] = $option['value'];
        }
        $harvest->quarters()->sync($quarter_ids);

        $details = collect($data['details']);

        $idDetails = $harvest->details()->pluck('id');
        $idDetailsToDestroy = $idDetails->filter(function ($id, int $key) use ($details) {
            return ! $details->firstWhere('id', $id);
        })->toArray();

        HarvestDetail::destroy($idDetailsToDestroy);
        // dd(json_encode($details));
        foreach ($details as $detail) {
            $plant = FindPlantByCode::call($detail['plant_code']);
            if (! $plant) {
                continue;
            }

            $harvest_detail = null;
            if ($detail['id']) {
                $harvest_detail = HarvestDetail::find($detail['id']);
            }

            if (! $harvest_detail) {
                $harvest_detail = new HarvestDetail;
            }

            $harvest_detail->harvest_id = $harvest->id;
            $harvest_detail->plant_id = $plant->id;
            $harvest_detail->quality = '';
            if (isset($detail['quality']) && isset($detail['quality']['value'])) {
                $harvest_detail->quality = Str::slug($detail['quality']['value']);
            }

            $harvest_detail->weight = $detail['weight'];
            $harvest_detail->save();
        }

        return $harvest;
    }
}

<?php

namespace App\Services\HarvestDetails;

use App\Models\HarvestDetail;
use App\Models\Harvest;
use App\Models\Plant;

class CreateHarvestDetails
{
    public static function call($data): HarvestDetail
    {
        $plant = Plant::where('code', $data['plant_code'])->first();

        $data['harvest_id'] = Harvest::latest()->first()->id;
        $data['plant_id'] = $plant->id;

        $harvest = HarvestDetail::create($data);
        return $harvest;
    }
}

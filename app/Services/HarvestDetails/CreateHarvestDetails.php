<?php

namespace App\Services\HarvestDetails;

use App\Models\HarvestDetail;
use App\Models\Harvest;
use App\Models\Plant;
use App\Services\Plants\FindPlantByCode;

use Illuminate\Support\Str;

class CreateHarvestDetails
{
    public static function call($data): HarvestDetail
    {
        $plant = FindPlantByCode::call($data['plant_code']);

        $data['harvest_id'] = Harvest::latest()->first()->id;
        $data['plant_id'] = $plant->id;
        $data['quality'] = Str::slug($data['quality']);

        $harvest = HarvestDetail::create($data);
        return $harvest;
    }
}

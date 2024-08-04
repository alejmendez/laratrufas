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

        $harvest = new HarvestDetail;
        $harvest->harvest_id = Harvest::latest()->first()->id;
        $harvest->plant_id = $plant->id;
        $harvest->quality = Str::slug($data['quality']);
        $harvest->weight = $data['weight'];
        $harvest->save();

        return $harvest;
    }
}

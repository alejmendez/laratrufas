<?php

namespace Modules\Field\Services\HarvestDetails;

use Modules\Field\Models\Harvest;
use Modules\Field\Models\HarvestDetail;
use Modules\Field\Services\Plants\FindPlantByCode;
use Illuminate\Support\Str;

class CreateHarvestDetails
{
    public static function call($data): HarvestDetail
    {
        $plant = FindPlantByCode::call($data['plant_code']);

        $harvest = new HarvestDetail;
        $harvest->harvest_id = Harvest::latest()->first()->id;
        $harvest->plant_id = $plant->id;
        $harvest->quality = Str::slug($data['quality'] ?? '');
        $harvest->weight = $data['weight'];
        $harvest->save();

        return $harvest;
    }
}

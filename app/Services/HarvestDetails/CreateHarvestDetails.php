<?php

namespace App\Services\HarvestDetails;

use App\Models\HarvestDetails;

class CreateHarvestDetails
{
    public static function call($data): HarvestDetails
    {
        $harvest = HarvestDetails::create($data);
        $harvest->quarters()->attach($data['quarter_ids']);
        return $harvest;
    }
}

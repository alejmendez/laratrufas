<?php

namespace App\Services\Harvests;

use App\Models\Harvest;
use App\Models\HarvestDetail;

class CreateHarvest
{
    public static function call($data): Harvest
    {
        $harvest = Harvest::create($data);
        $harvest->quarters()->attach($data['quarter_ids']);
        return $harvest;
    }
}

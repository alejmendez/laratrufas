<?php

namespace App\Services\Harvests;

use App\Models\Harvest;
use App\Models\HarvestDetail;

class CreateHarvest
{
    public static function call($data): Harvest
    {
        $harvest = new Harvest;

        $harvest->date = $date['date'];
        $harvest->batch = strtoupper($data['batch']);
        $harvest->dog_id = $date['dog_id']['value'];
        $harvest->farmer_id = $date['farmer_id']['value'];
        $harvest->assistant_id = $date['assistant_id']['value'];
        $harvest->save();

        $harvest->quarters()->attach($data['quarter_ids']);
        return $harvest;
    }
}

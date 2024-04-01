<?php

namespace App\Services\Harvests;

use App\Models\Harvest;
use App\Models\HarvestDetail;

class CreateHarvest
{
    public static function call($data): Harvest
    {
        $details = $data['details'];
        unset($data['details']);

        $harvest = Harvest::create($data);
        foreach ($details as $detail) {
            $detail['harvest_id'] = $harvest->id;
            HarvestDetail::create($detail);
        }
        return $harvest;
    }
}

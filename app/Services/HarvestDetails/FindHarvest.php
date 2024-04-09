<?php

namespace App\Services\HarvestDetailss;

use App\Models\HarvestDetails;

class FindHarvestDetails
{
    public static function call($id)
    {
        $harvest = HarvestDetails::findOrFail($id);

        return $harvest;
    }
}

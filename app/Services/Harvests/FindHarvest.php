<?php

namespace App\Services\Harvests;

use App\Models\Harvest;

class FindHarvest
{
    public static function call($id)
    {
        $harvest = Harvest::findOrFail($id);

        return $harvest;
    }
}

<?php

namespace App\Services\HarvestDetailss;

use App\Models\HarvestDetails;

class ListHarvestDetails
{
    public static function call($order = '', $search = '')
    {
        $harvests = HarvestDetails::with('quarter.field', 'vaccines')->order($order)->search($search);

        return $harvests;
    }
}

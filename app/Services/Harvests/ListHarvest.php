<?php

namespace App\Services\Harvests;

use App\Models\Harvest;

class ListHarvest
{
    public static function call($order = '', $search = '')
    {
        $harvests = Harvest::with('quarters.field', 'details')->order($order)->search($search);

        return $harvests;
    }
}

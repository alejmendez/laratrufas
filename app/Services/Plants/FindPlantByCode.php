<?php

namespace App\Services\Plants;

use App\Models\Plant;

class FindPlantByCode
{
    public static function call($code)
    {
        return Plant::firstWhere('code', trim(strtoupper($code)));
    }
}

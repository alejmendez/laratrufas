<?php

namespace App\Services\Plants;

use App\Models\Plant;

class FindPlantByCode
{
    public static function call($code)
    {
        return Plant::where('code', trim(strtoupper($code)))->first();
    }
}

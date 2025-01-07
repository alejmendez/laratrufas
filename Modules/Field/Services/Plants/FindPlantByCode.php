<?php

namespace Modules\Field\Services\Plants;

use Modules\Field\Models\Plant;

class FindPlantByCode
{
    public static function call($code)
    {
        return Plant::firstWhere('code', trim(strtoupper($code)));
    }
}

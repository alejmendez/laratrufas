<?php

namespace Modules\Field\Services\Plants;

use Modules\Field\Models\Plant;

class FindPlant
{
    public static function call($id)
    {
        $plant = Plant::findOrFail($id);

        return $plant;
    }
}

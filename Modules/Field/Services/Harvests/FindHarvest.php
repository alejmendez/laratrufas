<?php

namespace Modules\Field\Services\Harvests;

use Modules\Field\Models\Harvest;

class FindHarvest
{
    public static function call($id)
    {
        $harvest = Harvest::findOrFail($id);

        return $harvest;
    }
}

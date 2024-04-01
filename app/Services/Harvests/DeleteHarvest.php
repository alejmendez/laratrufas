<?php

namespace App\Services\Harvests;

use App\Models\Harvest;

class DeleteHarvest
{
    public static function call($id): void
    {
        Harvest::destroy($id);
    }
}

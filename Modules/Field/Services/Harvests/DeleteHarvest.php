<?php

namespace Modules\Field\Services\Harvests;

use Modules\Field\Models\Harvest;

class DeleteHarvest
{
    public static function call($id): void
    {
        Harvest::destroy($id);
    }
}

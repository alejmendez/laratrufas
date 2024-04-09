<?php

namespace App\Services\HarvestDetailss;

use App\Models\HarvestDetails;

class DeleteHarvestDetails
{
    public static function call($id): void
    {
        HarvestDetails::destroy($id);
    }
}

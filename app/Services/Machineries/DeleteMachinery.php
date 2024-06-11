<?php

namespace App\Services\Machineries;

use App\Models\Machinery;

class DeleteMachinery
{
    public static function call($id): void
    {
        Machinery::destroy($id);
    }
}

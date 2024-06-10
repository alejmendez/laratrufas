<?php

namespace App\Services\Machineries;

use App\Models\Machinery;

class FindMachinery
{
    public static function call($id)
    {
        $machinery = Machinery::findOrFail($id);

        return $machinery;
    }
}

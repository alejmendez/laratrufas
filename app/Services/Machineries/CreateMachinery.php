<?php

namespace App\Services\Machineries;

use App\Models\Machinery;

class CreateMachinery
{
    public static function call($data): Machinery
    {
        $machinery = Machinery::create($data);
        return $machinery;
    }
}

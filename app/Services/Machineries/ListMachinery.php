<?php

namespace App\Services\Machineries;

use App\Models\Machinery;

class ListMachinery
{
    public static function call($order = '', $search = '')
    {
        $machineries = Machinery::order($order)->search($search);

        return $machineries;
    }
}

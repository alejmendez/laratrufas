<?php

namespace App\Services\Machineries;

use App\Models\Machinery;

class ListMachinery
{
    public static function call($order = '', $search = '')
    {
        $machineries = Machinery::order($order);

        if ($search) {
            $machineries->whereAny([
                'name',
                'purchase_date',
                'last_maintenance',
                'purchase_location',
                'contact',
            ], 'LIKE', "%{$search}%");
        }

        return $machineries;
    }
}

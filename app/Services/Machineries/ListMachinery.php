<?php

namespace App\Services\Machineries;

use App\Models\Machinery;

class ListMachinery
{
    public static function call($order = '', $search = '')
    {
        $machineries = Machinery::select(
            'id',
            'name',
            'purchase_date',
            'last_maintenance',
            'purchase_location',
            'contact',
        )->order($order);

        if ($search) {
            $machineries->whereAny([
                'name',
                'purchase_date',
                'last_maintenance',
                'purchase_location',
                'contact',
            ], 'ILIKE', "%{$search}%");
        }

        return $machineries;
    }
}

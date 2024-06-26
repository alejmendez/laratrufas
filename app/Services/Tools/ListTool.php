<?php

namespace App\Services\Tools;

use App\Models\Tool;

class ListTool
{
    public static function call($order = '', $search = '')
    {
        $tools = Tool::select(
            'id',
            'name',
            'purchase_date',
            'last_maintenance',
            'purchase_location',
            'contact',
        )->order($order);

        if ($search) {
            $tools->whereAny([
                'name',
                'purchase_date',
                'last_maintenance',
                'purchase_location',
                'contact',
            ], 'ILIKE', "%{$search}%");
        }

        return $tools;
    }
}

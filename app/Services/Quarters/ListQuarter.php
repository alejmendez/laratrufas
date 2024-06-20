<?php

namespace App\Services\Quarters;

use App\Models\Quarter;

class ListQuarter
{
    public static function call($order = '', $search = '')
    {
        $quarters = Quarter::leftJoin('fields', 'quarters.field_id', '=', 'fields.id')
            ->select('quarters.id', 'quarters.name', 'fields.name as field_name', 'area')
            ->withCount('plants')
            ->order($order);

        if ($search != '') {
            $quarters->whereAny([
                'quarters.name',
                'fields.name',
                'area',
                'plants_count',
            ], 'ILIKE', "%{$search}%");
        }

        return $quarters;
    }
}

<?php

namespace App\Services\Fields;

use App\Models\Field;

class ListField
{
    public static function call($order = '', $search = '')
    {
        $fields = Field::select('id', 'name', 'location', 'size')
            ->withCount('plants')
            ->order($order);

        if ($search) {
            $fields->whereAny([
                'name',
                'location',
                'size',
            ], 'ILIKE', "%{$search}%");
        }

        return $fields;
    }
}

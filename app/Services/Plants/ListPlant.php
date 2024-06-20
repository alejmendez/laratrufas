<?php

namespace App\Services\Plants;

use App\Models\Plant;

class ListPlant
{
    public static function call($order = '', $search = '')
    {
        $plants = Plant::select(
            'plants.id',
            'plants.code',
            'quarters.name as quarter_name',
            'fields.name as field_name',
            'plant_types.name as plant_type_name',
            'plants.age',
            'users.name as responsible_name'
        )
        ->join('quarters', 'plants.quarter_id', '=', 'quarters.id')
        ->join('fields', 'quarters.field_id', '=', 'fields.id')
        ->join('plant_types', 'plants.plant_type_id', '=', 'plant_types.id')
        ->join('users', 'quarters.responsible_id', '=', 'users.id')
        ->order($order);

        if ($search) {
            $plants->whereAny([
                'plants.code',
                'quarters.name',
                'fields.name',
                'plant_types.name',
                'plants.age',
                'users.name',
            ], 'ILIKE', "%{$search}%");
        }

        return $plants;
    }
}

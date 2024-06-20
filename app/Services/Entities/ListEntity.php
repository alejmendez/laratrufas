<?php

namespace App\Services\Entities;

use Illuminate\Support\Facades\DB;

class ListEntity
{
    public static function call($entity, $filter = [])
    {
        $entityQuery = match ($entity) {
            'field' => \App\Models\Field::select('id as value', 'name as text')->orderBy('name'),
            'quarter' => \App\Models\Quarter::select('id as value', 'name as text')->orderBy('name'),
            'quarterMultiselect' => self::quarterMultiselect(),
            'plant' => \App\Models\Plant::select('id as value', 'code as text')->orderBy('code'),
            'plant_type' => \App\Models\PlantType::select('id as value', 'name as text')->orderBy('name'),
            'tool' => \App\Models\Tool::select('id as value', 'name as text')->orderBy('name'),
            'machinery' => \App\Models\Machinery::select('id as value', 'name as text')->orderBy('name'),
            'dog' => \App\Models\Dog::select('id as value', 'name as text')->orderBy('name'),
            'harvest' => \App\Models\Harvest::select('id', 'batch', 'date')->orderBy('date'),
            'role' => \Spatie\Permission\Models\Role::select('name as value', 'name as text')->orderBy('name'),
            'responsible', 'couple', 'user' => \App\Models\User::select('id as value', DB::Raw("(name || ' ' || last_name) AS text"))->orderBy('name'),
            default => [],
        };

        if (is_array($entityQuery)) {
            return $entityQuery;
        }

        return self::applyFilter($entityQuery, $filter)->get();
    }

    protected static function applyFilter($query, $filter)
    {
        foreach ($filter as $field => $value) {
            $query->where($field, $value);
        }

        return $query;
    }

    protected static function quarterMultiselect() {
        return \App\Models\Quarter::with('field')
            ->orderBy('name')
            ->get()
            ->groupBy('field.name')
            ->map(function($group, $fieldName) {
                return [
                    'field' => $fieldName,
                    'quarters' => collect($group)->map(function($quarter) {
                        return [
                            'value' => $quarter->id,
                            'text' => $quarter->name,
                        ];
                    }),
                ];
            })
            ->values()
            ->toArray();
    }
}

<?php

namespace App\Services\Entities;

use App\Services\Harvests\HarvestAvailableYears;

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
            'harvest' => \App\Models\Harvest::select('id', 'week', 'batch')->orderBy('date'),
            'role' => \Spatie\Permission\Models\Role::select('name as value', 'name as text')->orderBy('name'),
            'harvest_available_years' => HarvestAvailableYears::call(),
            'importer' => \App\Models\Importer::select('id as value', 'name as text')->orderBy('name'),
            'responsible', 'couple', 'user' => \App\Models\User::select('id as value', 'full_name as text')->orderBy('full_name'),
            default => [],
        };

        if (is_array($entityQuery) || $entityQuery instanceof \Illuminate\Support\Collection) {
            return $entityQuery;
        }

        return self::applyFilter($entityQuery, $filter)->get();
    }

    protected static function applyFilter($query, $filter)
    {
        foreach ($filter as $field => $value) {
            if (is_array($value)) {
                $query->whereIn($field, $value);
            } else {
                $query->where($field, $value);
            }
        }

        return $query;
    }

    protected static function quarterMultiselect()
    {
        return \App\Models\Quarter::leftJoin('fields', 'quarters.field_id', '=', 'fields.id')
            ->select('fields.id as field_id', 'fields.name as field_name', 'quarters.id', 'quarters.name')
            ->orderBy('fields.name')
            ->orderBy('quarters.name')
            ->get()
            ->groupBy('field_id')
            ->map(function ($group, $fieldName) {
                return [
                    'text' => $group[0]->field_name,
                    'items' => collect($group)->map(function ($quarter) {
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

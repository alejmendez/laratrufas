<?php

namespace App\Services\Entities;

class ListEntity
{
    public static function call($entity, $filter = [])
    {
        $entityQuery = match ($entity) {
            'field' => \App\Models\Field::select('id as value', 'name as text')->orderBy('name'),
            'quarter' => \App\Models\Quarter::select('id as value', 'name as text')->orderBy('name'),
            'plant' => \App\Models\Plant::select('id as value', 'code as text')->orderBy('code'),
            'tool' => \App\Models\Tool::select('id as value', 'name as text')->orderBy('name'),
            'machinery' => \App\Models\Machinery::select('id as value', 'name as text')->orderBy('name'),
            'responsible' => \App\Models\User::select('id as value', \DB::Raw("(name || ' ' || last_name) AS text"))->orderBy('name'),
            default => false,
        };

        if ($entityQuery === false) {
            return [];
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
}

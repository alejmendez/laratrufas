<?php

namespace Modules\Core\Services;

use Illuminate\Support\Facades\DB;
use Modules\Fields\Models\CategoryProduct;
use Modules\Fields\Models\Dog;
use Modules\Fields\Models\Field;
use Modules\Fields\Models\Harvest;
use Modules\Fields\Models\Importer;
use Modules\Fields\Models\Machinery;
use Modules\Fields\Models\Plant;
use Modules\Fields\Models\PlantType;
use Modules\Fields\Models\Quarter;
use Modules\Fields\Models\SecurityEquipment;
use Modules\Fields\Models\Tool;
use Modules\Fields\Services\Harvests\HarvestAvailableWeeks;
use Modules\Fields\Services\Harvests\HarvestAvailableYears;
use Modules\Fields\Services\Liquidations\LiquidationAvailableYears;
use Modules\Users\Models\User;

class ListEntity
{
    public static function call($entity, $filter = [])
    {
        $entityQuery = match ($entity) {
            'field' => Field::select('id as value', 'name as text')->orderBy('name'),
            'quarter' => Quarter::select('id as value', 'name as text')->orderBy('name'),
            'quarterMultiselect' => self::quarterMultiselect(),
            'plant' => Plant::select('id as value', 'code as text')->orderBy('code'),
            'plant_type' => PlantType::select('id as value', 'name as text')->orderBy('name'),
            'tool' => Tool::select('id as value', 'name as text')->orderBy('name'),
            'security_equipment' => SecurityEquipment::select('id as value', 'name as text')->orderBy('name'),
            'machinery' => Machinery::select('id as value', 'name as text')->orderBy('name'),
            'dog' => Dog::select('id as value', 'name as text')->orderBy('name'),
            'harvest' => Harvest::select('id', 'week', 'batch')->orderBy('date'),
            'role' => \Spatie\Permission\Models\Role::select('name as value', 'name as text')->orderBy('name'),
            'harvest_available_years' => HarvestAvailableYears::call(),
            'harvest_available_weeks' => HarvestAvailableWeeks::call(),
            'liquidation_available_years' => LiquidationAvailableYears::call(),
            'importer' => Importer::select('id as value', 'name as text')->orderBy('name'),
            'category_products' => CategoryProduct::select('id', 'name', 'is_commercial'),
            'responsible', 'couple', 'user' => User::select('id as value', 'full_name as text')->orderBy('full_name'),
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
        return Quarter::leftJoin('fields', 'quarters.field_id', '=', 'fields.id')
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

<?php

namespace App\Services\Graphs;

use App\Models\Field;
use App\Models\Harvest;
use App\Models\Liquidation;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class GraphDataField
{
    public static function call($id, $year, $type, $filters)
    {
        $field = Field::findOrFail($id);
        $typeQuery = match ($type) {
            'field-on-demand-production' => self::onDemandProduction($field, $year),
            'field-sales-vs-shrinkage' => self::salesVsShrinkage($field, $year),
            'field-shrinkage-detail' => self::shrinkageDetail($field, $year),
            'field-type-of-shrinkage' => self::typeOfShrinkage($field, $year),
            'field-average-sales-value-per-kilogram' => self::averageSalesValuePerKilogram($field, $year),
            default => [],
        };

        if (is_array($typeQuery) || $typeQuery instanceof \Illuminate\Support\Collection) {
            return $typeQuery;
        }

        return self::applyFilter($typeQuery, $filter)->get();
    }

    protected static function onDemandProduction($field, $year)
    {
        $quarter_ids = $field->quarters->pluck('id');
        $details = Harvest::leftJoin('harvest_details', 'harvests.id', '=', 'harvest_details.harvest_id')
            ->select('week', 'year')
            ->selectRaw('sum(harvest_details.weight) as weight_sum')
            ->where('year', $year)
            ->whereIn('harvest_details.quarter_id', $quarter_ids)
            ->groupBy('week', 'year')
            ->orderBy('year', 'desc')
            ->orderBy('week', 'asc')
            ->get();

        $labels = $details->map(function ($d) {
            return "Sem " . $d->week;
        })->unique()->values();

        $data = $details->map(function ($d) {
            return round(floatval($d->weight_sum / 1000), 2);
        });
        return [
            'title' => 'Total de Kg por Semana Año ' . $year,
            'labels' => $labels,
            'series' => [
                [
                    'name' => "Kg",
                    'data' => $data,
                ]
            ],
        ];
    }

    protected static function salesVsShrinkage($field, $year)
    {
        $liquidations = Liquidation::leftJoin('liquidation_products', 'liquidations.id', '=', 'liquidation_products.liquidation_id')
            ->leftJoin('category_products', 'liquidation_products.category_product_id', '=', 'category_products.id')
            ->select('week', 'year', 'category_products.is_commercial')
            ->selectRaw('sum(liquidation_products.weight) as weight_sum')
            ->where('field_id', $field->id)
            ->where('year', $year)
            ->groupBy('week', 'year', 'category_products.is_commercial')
            ->orderBy('year', 'desc')
            ->orderBy('week', 'asc')
            ->get();

        $labels = $liquidations->map(function ($l) {
            return "Sem " . $l->week;
        })->unique()->values();

        $data_commercial = $liquidations->filter(function ($l) {
            return $l->is_commercial;
        })->map(function ($l) {
            return round($l->weight_sum, 2);
        })->values();

        $data_not_commercial = $liquidations->filter(function ($l) {
            return !$l->is_commercial;
        })->map(function ($l) {
            return round($l->weight_sum, 2);
        })->values();

        return [
            'title' => 'KGS. Venta vs KGS. Merma Año ' . $year,
            'labels' => $labels,
            'series' => [
                [
                    'name' => "KGS Comerciales",
                    'data' => $data_commercial,
                ],
                [
                    'name' => "KGS Merma",
                    'data' => $data_not_commercial,
                ],
            ],
        ];
    }

    protected static function shrinkageDetail($field, $year)
    {
        $liquidations = Liquidation::leftJoin('liquidation_products', 'liquidations.id', '=', 'liquidation_products.liquidation_id')
            ->leftJoin('category_products', 'liquidation_products.category_product_id', '=', 'category_products.id')
            ->select(
                'is_commercial',
                DB::raw('sum(weight_with_earth) as weight_with_earth'),
                DB::raw('sum(liquidation_products.weight) as weight_sum')
            )
            ->where('field_id', $field->id)
            ->where('year', $year)
            ->groupBy('category_products.is_commercial')
            ->get();

        $labels = [
            'KGS Tierra',
            'KGS Comerciales',
            'KGS Merma',
        ];

        $data_grouped = $liquidations->keyBy('is_commercial');

        $data_not_comercial = $data_grouped[0];
        $data_comercial = $data_grouped[1];

        $weight_comercial = round($data_comercial->weight_sum, 2);
        $weight_not_comercial = round($data_not_comercial->weight_sum, 2);


        $weight_with_earth_query = Liquidation::select(DB::raw('sum(weight_with_earth) as weight_with_earth'))
            ->where('field_id', $field->id)
            ->where('year', $year)
            ->first();

        $weight_with_earth = round($weight_with_earth_query->weight_with_earth, 2);

        $data = [
            $weight_with_earth,
            $weight_comercial,
            $weight_not_comercial,
        ];

        return [
            'title' => 'Cosecha Año ' . $year,
            'labels' => $labels,
            'series' => $data,
        ];
    }

    protected static function typeOfShrinkage($field, $year)
    {
        $liquidations = Liquidation::leftJoin('liquidation_products', 'liquidations.id', '=', 'liquidation_products.liquidation_id')
            ->leftJoin('category_products', 'liquidation_products.category_product_id', '=', 'category_products.id')
            ->select('week', 'year', 'category_products.name')
            ->selectRaw('sum(liquidation_products.weight) as weight_sum')
            ->where('field_id', $field->id)
            ->where('year', $year)
            ->where('category_products.is_commercial', false)
            ->groupBy('week', 'year', 'category_products.name')
            ->orderBy('year', 'desc')
            ->orderBy('week', 'asc')
            ->get();

        $labels = $liquidations->map(function ($l) {
            return "Sem " . $l->week;
        })->unique()->values();

        $detailsByCategory = $liquidations->groupBy('name');
        $types = $detailsByCategory->keys();

        $series = $detailsByCategory->map(function($l, $categoryName) {
            return [
                'name' => $categoryName,
                'data' => $l->map(fn ($ll) => floatval($ll->weight_sum)),
            ];
        })->values();

        return [
            'title' => 'Merma por Tipo (%) Año ' . $year,
            'labels' => $labels,
            'series' => $series,
        ];
    }

    protected static function averageSalesValuePerKilogram($field, $year)
    {
        $liquidations = Liquidation::leftJoin('liquidation_products', 'liquidations.id', '=', 'liquidation_products.liquidation_id')
            ->leftJoin('category_products', 'liquidation_products.category_product_id', '=', 'category_products.id')
            ->select('week', 'year', 'category_products.is_commercial')
            ->selectRaw('sum(liquidation_products.weight) as weight_sum')
            ->where('field_id', $field->id)
            ->where('year', $year)
            ->groupBy('week', 'year', 'category_products.is_commercial')
            ->orderBy('year', 'desc')
            ->orderBy('week', 'asc')
            ->get();

        $labels = $liquidations->map(function ($l) {
            return "Sem " . $l->week;
        })->unique()->values();

        $data_commercial = $liquidations->filter(function ($l) {
            return $l->is_commercial;
        })->map(function ($l) {
            return round($l->weight_sum, 2);
        })->values();

        $data_not_commercial = $liquidations->filter(function ($l) {
            return !$l->is_commercial;
        })->map(function ($l) {
            return round($l->weight_sum, 2);
        })->values();

        return [
            'title' => 'Venta vs Merma (%) Año ' . $year,
            'labels' => $labels,
            'series' => [
                [
                    'name' => "KGS Comerciales",
                    'data' => $data_commercial,
                ],
                [
                    'name' => "KGS Merma",
                    'data' => $data_not_commercial,
                ],
            ],
        ];
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
}

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
            'field-comparative-of-selling-price-x-kgs' => self::comparativeOfSellingPriceXKgs($field, $year),
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
                DB::raw('sum(liquidation_products.weight) as weight_sum')
            )
            ->where('field_id', $field->id)
            ->where('year', $year)
            ->groupBy('category_products.is_commercial')
            ->get();

        $labels = [
            'KGS Comerciales',
            'KGS Merma',
            'KGS Tierra',
        ];

        $data_grouped = $liquidations->keyBy('is_commercial');

        $data_not_comercial = $data_grouped[0];
        $data_comercial = $data_grouped[1];

        $weight_comercial = round($data_comercial->weight_sum, 2);
        $weight_not_comercial = round($data_not_comercial->weight_sum, 2);


        $weight_earth_query = Liquidation::select(DB::raw('sum(weight_with_earth) - sum(weight_washed) as weight_earth'))
            ->where('field_id', $field->id)
            ->where('year', $year)
            ->first();

        $weight_earth = round($weight_earth_query->weight_earth, 2);

        $data = [
            $weight_comercial,
            $weight_not_comercial,
            $weight_earth,
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

    protected static function comparativeOfSellingPriceXKgs($field, $year)
    {
        /*
        - valor del dolar de la liquidacion
        - peso neto de cada tipo de trufa / total $ ento
            - total $ ento = peso de cat * dolar de cat - Gastos Exportador USD (20%) - Comisión USD (10%)
        */
        $liquidations = Liquidation::leftJoin('liquidation_products', 'liquidations.id', '=', 'liquidation_products.liquidation_id')
            ->leftJoin('category_products', 'liquidation_products.category_product_id', '=', 'category_products.id')
            ->select('week', 'year', 'liquidation_products.price', 'liquidation_products.weight')
            ->where('field_id', $field->id)
            ->where('year', $year)
            ->where('category_products.is_commercial', true)
            ->where('liquidation_products.price', '!=', 0)
            ->orderBy('year', 'desc')
            ->orderBy('week', 'asc')
            ->get();

        $groupedData = $liquidations->groupBy('week');

        $labels = [];
        $usd_avg_exporter = [];
        $usd_avg_field = [];

        // Recorrer cada grupo por semana
        foreach ($groupedData as $week => $items) {
            $items = collect($items)->map(function($item) {
                $item['weight'] = floatval($item['weight']);
                $item['price'] = floatval($item['price']);
                return $item;
            });
            $labels[] = "Sem " . $week;

            $avgPrice = $items->avg('price');
            $sumWeight = $items->sum('weight');
            $usd_avg_exporter[] = round((float) $avgPrice, 2);

            $avg_field = $items->reduce(function ($carry, $item) {
                return $carry + $item['weight'] * $item['price'] * 0.7;
            }, 0);
            $usd_avg_field[] = round($avg_field / $sumWeight, 2);
        }

        return [
            'title' => 'Venta vs Merma (%) Año ' . $year,
            'labels' => $labels,
            'series' => [
                [
                    'name' => "USD promedio Exportador",
                    'data' => $usd_avg_exporter,
                ],
                [
                    'name' => "USD promedio Campo",
                    'data' => $usd_avg_field,
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

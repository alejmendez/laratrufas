<?php

namespace App\Services\Harvests;

use Illuminate\Support\Facades\DB;
use App\Models\Harvest;
use App\Utils\Query;

class ListHarvest
{
    public static function call($order = '', $search = '')
    {
        $subquery = DB::table('harvests')
            ->select(
                'harvests.id',
                'harvests.date',
                'harvests.batch',
                DB::raw('SUM(harvest_details.weight) as total_weight'),
                DB::raw("STRING_AGG(DISTINCT plants.code, ', ') as plant_codes"),
                DB::raw("STRING_AGG(DISTINCT quarters.name, ', ') as quarter_names"),
                DB::raw("CONCAT(users.name, ' ', users.last_name) as farmer_name")
            )
            ->leftJoin('harvest_details', 'harvests.id', '=', 'harvest_details.harvest_id')
            ->leftJoin('plants', 'harvest_details.plant_id', '=', 'plants.id')
            ->leftJoin('harvest_quarter', 'harvest_quarter.harvest_id', '=', 'harvests.id')
            ->leftJoin('quarters', 'harvest_quarter.quarter_id', '=', 'quarters.id')
            ->leftJoin('users', 'harvests.farmer_id', '=', 'users.id')
            ->groupBy('harvests.id', 'harvests.date', 'harvests.batch', 'users.name', 'users.last_name');

        $harvests = DB::table(DB::raw("({$subquery->toSql()}) as harvest"));

        Query::order($harvests, $order);

        if ($search) {
            $harvests->whereAny([
                'date',
                'batch',
                'total_weight',
                'plant_codes',
                'quarter_names',
                'farmer_name',
            ], 'ILIKE', "%{$search}%");
        }

        return $harvests;
    }
}

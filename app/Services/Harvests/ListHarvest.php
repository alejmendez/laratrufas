<?php

namespace App\Services\Harvests;

use Illuminate\Support\Facades\DB;
use App\Utils\Query;

class ListHarvest
{
    public static function call($order = '', $search = '', $filters = [])
    {
        $subquery = DB::table('harvests')
            ->select(
                'harvests.id',
                'harvests.date',
                'harvests.batch',
                DB::raw('(select SUM(harvest_details.weight) from harvest_details where harvest_id = harvests.id) as total_weight'),
                DB::raw("(select count(*) from harvest_details where harvest_id = harvests.id) as count_details"),
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

        if ($filters['year']) {
            $start_date = $filters['year'] . '-01-01';
            $end_date = $filters['year'] . '-12-31';
            $harvests->whereBetween('date', [$start_date, $end_date]);
        }

        if ($search) {
            $harvests->whereAny([
                'date',
                'batch',
                'total_weight',
                'count_details',
                'quarter_names',
                'farmer_name',
            ], 'ILIKE', "%{$search}%");
        }

        return $harvests;
    }
}

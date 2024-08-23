<?php

namespace App\Services\Harvests;


use Illuminate\Support\Facades\DB;

use App\Models\Harvest;
use App\Services\Primevue\PrimevueDatatables;

class ListHarvest
{
    public static function call($params = [])
    {
        $query = Harvest::select('harvests.id', 'harvests.date', 'harvests.batch')
            ->selectRaw('string_agg(DISTINCT fields.name, \', \') as field_names')
            ->selectRaw('string_agg(DISTINCT quarters.name, \', \') as quarter_names')
            ->selectRaw('SUM(harvest_details.weight) as total_weight')
            ->selectRaw('COUNT(harvest_details.id) as unit_count')
            ->selectRaw("CONCAT(users.name, ' ', users.last_name) as farmer_name")
            ->leftjoin('harvest_quarter', 'harvests.id', '=', 'harvest_quarter.harvest_id')
            ->leftjoin('quarters', 'harvest_quarter.quarter_id', '=', 'quarters.id')
            ->leftjoin('fields', 'quarters.field_id', '=', 'fields.id')
            ->leftjoin('harvest_details', 'harvests.id', '=', 'harvest_details.harvest_id')
            ->leftjoin('users', 'harvests.farmer_id', '=', 'users.id')
            ->groupBy('harvests.id', 'harvests.date', 'harvests.batch', 'users.name', 'users.last_name');

        $searchableColumns = ['date', 'batch', 'quarters.field.name', 'quarters.name', 'farmer.name', 'farmer.last_name'];
        $datatable = new PrimevueDatatables($params, $searchableColumns);
        $harvests = $datatable->of($query)->make();

        return $harvests;
    }
}

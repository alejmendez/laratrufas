<?php

namespace App\Services\Harvests;

use Illuminate\Support\Facades\DB;
use App\Models\Harvest;
use App\Utils\Query;

class HarvestAvailableYears
{
    public static function call()
    {
        $subquery = DB::table('harvests')
            ->select(DB::raw('extract(year from date) as years'));

        $years = DB::table(DB::raw("({$subquery->toSql()}) as harvest_years"))
            ->select('years as value', 'years as text')
            ->groupBy('years')
            ->get();

        return $years;
    }
}

<?php

namespace App\Services\Harvests;

use Illuminate\Support\Facades\DB;
use App\Models\Harvest;
use App\Utils\Query;

class HarvestAvailableYears
{
    public static function call()
    {
        return DB::table('harvests')
            ->select('year')
            ->distinct()
            ->get()
            ->map(function ($row) {
                return ['value' => $row->year, 'text' => $row->year];
            });
    }
}

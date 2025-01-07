<?php

namespace Modules\Field\Services\Harvests;

use Illuminate\Support\Facades\DB;

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

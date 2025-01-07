<?php

namespace Modules\Fields\Services\Harvests;

use Illuminate\Support\Facades\DB;

class HarvestAvailableWeeks
{
    public static function call()
    {
        return DB::table('harvests')
            ->select('week')
            ->distinct()
            ->get()
            ->map(function ($row) {
                return ['value' => $row->week, 'text' => 'Semana '.$row->week];
            });
    }
}

<?php

namespace Modules\Fields\Services\Harvests;

use Modules\Fields\Models\Field;
use Modules\Fields\Models\Harvest;

class HarvestAvailableLastYear
{
    public static function call(Field $field)
    {
        return cache()->remember('last_years_harvest_'.$field->id, now()->addDay(), function () use ($field) {
            $quarter_ids = $field->quarters->pluck('id');
            $current_year = (int) date('Y');
            $year = Harvest::join('harvest_details', 'harvests.id', '=', 'harvest_details.harvest_id')
                ->whereIn('harvest_details.quarter_id', $quarter_ids)
                ->max('harvests.year');

            return $year > $current_year ? $current_year : $year;
        });
    }
}

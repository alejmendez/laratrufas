<?php

namespace App\Services\PlantDetails;

use App\Models\Plant;
use App\Models\Quarter;
use App\Models\PlantDetail;

class FindPlantDetails
{
    public static function get_by_plant(Plant $plant, $show_harvests = false)
    {
        return self::get_by_plant_id($plant->id, $show_harvests);
    }

    public static function get_by_plant_id($id, $show_harvests = false)
    {
        $query = PlantDetail::where('plant_id', $id);
        return self::get_details($query, $show_harvests);
    }

    public static function get_by_quarter_id($id, $show_harvests = false)
    {
        $query = PlantDetail::whereRaw('plant_id IN (SELECT id FROM plants WHERE quarter_id = ?)', [$id]);
        return self::get_details($query, $show_harvests);
    }

    public static function get_by_field_id($id, $show_harvests = false)
    {
        $query = PlantDetail::whereRaw('plant_id IN (SELECT id FROM plants WHERE quarter_id in (SELECT id FROM quarters WHERE field_id = ?))', [$id]);
        return self::get_details($query, $show_harvests);
    }

    public static function get_details($query, $show_harvests = false)
    {
        if (!$show_harvests) {
            $query->where('type', '!=', 'harvest');
        }
        return $query->get();
    }
}

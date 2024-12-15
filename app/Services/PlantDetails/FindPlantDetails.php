<?php

namespace App\Services\PlantDetails;

use App\Models\Plant;
use App\Models\Quarter;
use App\Models\PlantDetail;

class FindPlantDetails
{
    public static function get_by_plant(Plant $plant)
    {
        return $plant->details;
    }

    public static function get_by_plant_id(int $id)
    {
        $plant = Plant::findOrFail($id);
        return self::get_by_plant($plant);
    }

    public static function get_by_quarter_id(int $id)
    {
        return PlantDetail::whereRaw('plant_id IN (SELECT id FROM plants WHERE quarter_id = ?)', [$id])->get();
    }

    public static function get_by_field_id(int $id)
    {
        return PlantDetail::whereRaw('plant_id IN (SELECT id FROM plants WHERE quarter_id in (SELECT id FROM quarters WHERE field_id = ?))', [$id])->get();
    }
}

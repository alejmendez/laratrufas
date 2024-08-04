<?php

namespace App\Services\Plants;

use App\Models\Plant;

class UpdatePlant
{
    public static function call($id, $data): Plant
    {
        $plant = Plant::findOrFail($id);

        $plant->quarter_id = $data['quarter_id']['value'];
        $plant->code = $data['code'];
        $plant->row = $data['row'];
        $plant->plant_type_id = $data['plant_type_id']['value'];
        $plant->age = $data['age'];
        $plant->planned_at = $data['planned_at'];
        $plant->nursery_origin = $data['nursery_origin'];

        $plant->save();

        return $plant;
    }
}

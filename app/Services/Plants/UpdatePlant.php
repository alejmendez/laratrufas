<?php

namespace App\Services\Plants;

use App\Models\Plant;

class UpdatePlant
{
    public static function call($id, $data): Plant
    {
        unset($data['id']);
        $plant = Plant::findOrFail($id);

        $plant->update($data);

        return $plant;
    }
}

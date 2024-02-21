<?php

namespace App\Services\Plants;

use App\Models\Plant;

class UpdatePlant
{
    public static function call($id, $data, $avatar): Plant
    {
        unset($data['id']);
        $plant = Plant::findOrFail($id);

        if (!$data['blueprint']) {
            unset($data['blueprint']);
        }

        if ($data['blueprintRemove'] === '1') {
            $data['blueprint'] = null;
        }

        $plant->update($data);

        return $plant;
    }
}

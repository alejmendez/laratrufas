<?php

namespace App\Services\Machineries;

use App\Models\Machinery;

class CreateMachinery
{
    public static function call($data): Machinery
    {
        $machinery = new Machinery;

        $machinery->name = $data['name'];
        $machinery->purchase_date = $data['purchase_date'];
        $machinery->last_maintenance = $data['last_maintenance'];
        $machinery->purchase_location = $data['purchase_location'];
        $machinery->type = $data['type'];
        $machinery->contact = $data['contact'];
        $machinery->save();

        return $machinery;
    }
}

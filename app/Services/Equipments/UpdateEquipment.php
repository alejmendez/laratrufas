<?php

namespace App\Services\Machineries;

use App\Models\Machinery;
use App\Models\MachineryVaccine;

class UpdateMachinery
{
    public static function call($id, $data): Machinery
    {
        $machinery = Machinery::findOrFail($id);
        $machinery->update($data);

        return $machinery;
    }
}

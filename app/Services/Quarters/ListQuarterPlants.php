<?php

namespace App\Services\Quarters;

use App\Models\Plant;

class ListQuarterPlants
{
    public static function call($id)
    {
        $plants = Plant::select('id', 'code', 'row', 'position')->where('quarter_id', $id)->get();

        return $plants;
    }
}

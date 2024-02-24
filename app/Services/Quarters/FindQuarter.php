<?php

namespace App\Services\Quarters;

use App\Models\Quarter;

class FindQuarter
{
    public static function call($id)
    {
        $quarter = Quarter::with('responsible', 'field', 'plants')->findOrFail($id);

        return $quarter;
    }
}

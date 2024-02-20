<?php

namespace App\Services\Quarters;

use App\Models\Quarter;

class ListQuarter
{
    public static function call($order = '', $search = '')
    {
        $quarter = Quarter::with('field', 'plants')->order($order)->search($search);

        return $quarter;
    }
}

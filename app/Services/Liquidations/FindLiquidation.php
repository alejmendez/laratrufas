<?php

namespace App\Services\Liquidations;

use App\Models\Liquidation;

class FindLiquidation
{
    public static function call($id)
    {
        $liquidation = Liquidation::findOrFail($id);

        return $liquidation;
    }
}

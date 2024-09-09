<?php

namespace App\Services\Liquidations;

use App\Models\Liquidation;

class DeleteLiquidation
{
    public static function call($id): void
    {
        Liquidation::destroy($id);
    }
}

<?php

namespace Modules\Field\Services\Liquidations;

use Modules\Field\Models\Liquidation;

class FindLiquidation
{
    public static function call($id)
    {
        $liquidation = Liquidation::findOrFail($id);

        return $liquidation;
    }
}

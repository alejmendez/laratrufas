<?php

namespace Modules\Field\Services\Liquidations;

use Modules\Field\Models\Liquidation;

class DeleteLiquidation
{
    public static function call($id): void
    {
        Liquidation::destroy($id);
    }
}

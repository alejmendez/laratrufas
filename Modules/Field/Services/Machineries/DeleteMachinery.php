<?php

namespace Modules\Field\Services\Machineries;

use Modules\Field\Models\Machinery;

class DeleteMachinery
{
    public static function call($id): void
    {
        Machinery::destroy($id);
    }
}

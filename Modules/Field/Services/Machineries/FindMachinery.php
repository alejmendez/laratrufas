<?php

namespace Modules\Field\Services\Machineries;

use Modules\Field\Models\Machinery;

class FindMachinery
{
    public static function call($id)
    {
        $machinery = Machinery::findOrFail($id);

        return $machinery;
    }
}

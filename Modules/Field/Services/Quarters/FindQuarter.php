<?php

namespace Modules\Field\Services\Quarters;

use Modules\Field\Models\Quarter;

class FindQuarter
{
    public static function call($id)
    {
        $quarter = Quarter::with('responsible', 'field')
            ->withCount('plants')
            ->findOrFail($id);

        return $quarter;
    }
}

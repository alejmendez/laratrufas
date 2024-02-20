<?php

namespace App\Services\Fields;

use App\Models\Field;

class FindField
{
    public static function call($id)
    {
        $field = Field::with('owner', 'plants')->findOrFail($id);

        return $field;
    }
}

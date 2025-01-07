<?php

namespace Modules\Field\Services\Fields;

use Modules\Field\Models\Field;

class DeleteField
{
    public static function call($id): void
    {
        Field::destroy($id);
    }
}

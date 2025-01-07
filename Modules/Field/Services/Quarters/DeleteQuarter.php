<?php

namespace Modules\Field\Services\Quarters;

use Modules\Field\Models\Quarter;

class DeleteQuarter
{
    public static function call($id): void
    {
        Quarter::destroy($id);
    }
}

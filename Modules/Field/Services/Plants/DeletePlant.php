<?php

namespace Modules\Field\Services\Plants;

use Modules\Field\Models\Plant;

class DeletePlant
{
    public static function call($id): void
    {
        Plant::destroy($id);
    }
}

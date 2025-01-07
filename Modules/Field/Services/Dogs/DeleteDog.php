<?php

namespace Modules\Field\Services\Dogs;

use Modules\Field\Models\Dog;

class DeleteDog
{
    public static function call($id): void
    {
        Dog::destroy($id);
    }
}

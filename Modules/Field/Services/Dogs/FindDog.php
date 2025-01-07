<?php

namespace Modules\Field\Services\Dogs;

use Modules\Field\Models\Dog;

class FindDog
{
    public static function call($id)
    {
        $dog = Dog::findOrFail($id);

        return $dog;
    }
}

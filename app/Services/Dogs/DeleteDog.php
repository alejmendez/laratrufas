<?php

namespace App\Services\Dogs;

use App\Models\Dog;

class DeleteDog
{
    public static function call($id): void
    {
        Dog::destroy($id);
    }
}

<?php

namespace App\Services\Owners;

use App\Models\Owner;

class DeleteOwner
{
    public static function call($id): void
    {
        Owner::destroy($id);
    }
}

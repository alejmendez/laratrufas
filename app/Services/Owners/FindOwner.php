<?php

namespace App\Services\Owners;

use App\Models\Owner;

class FindOwner
{
    public static function call($id)
    {
        $owner = Owner::findOrFail($id);

        return $owner;
    }
}

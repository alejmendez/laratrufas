<?php

namespace App\Services\Owners;

use App\Models\Owner;

class CreateOwner
{
    public static function call($data): Owner
    {
        $owner = Owner::create($data);
        return $owner;
    }
}

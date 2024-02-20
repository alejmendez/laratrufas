<?php

namespace App\Services\Owners;

use App\Models\Owner;

class CreateOrUpdateOwner
{
    public static function call($dni, $name): Owner
    {
        $owner = Owner::updateOrCreate(
            ['dni' => $dni],
            ['name' => $name]
        );
        return $owner;
    }
}

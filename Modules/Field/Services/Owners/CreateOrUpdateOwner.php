<?php

namespace Modules\Field\Services\Owners;

use Modules\Field\Models\Owner;

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

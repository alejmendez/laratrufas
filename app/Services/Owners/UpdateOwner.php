<?php

namespace App\Services\Owners;

use App\Models\Owner;

class UpdateOwner
{
    public static function call($id, $data): Owner
    {
        $owner = Owner::findOrFail($id);

        $owner->name = $data['name'];
        $owner->dni = $data['dni'];
        $owner->save();

        return $owner;
    }
}

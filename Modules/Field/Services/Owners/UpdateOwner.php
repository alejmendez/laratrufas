<?php

namespace Modules\Field\Services\Owners;

use Modules\Field\Models\Owner;

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

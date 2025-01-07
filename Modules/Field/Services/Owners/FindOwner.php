<?php

namespace Modules\Field\Services\Owners;

use Modules\Field\Models\Owner;

class FindOwner
{
    public static function call($id)
    {
        $owner = Owner::findOrFail($id);

        return $owner;
    }
}

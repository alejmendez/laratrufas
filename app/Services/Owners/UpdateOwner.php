<?php

namespace App\Services\Owners;

use App\Models\Owner;

class UpdateOwner
{
    public static function call($id, $data): Owner
    {
        unset($data['id']);
        $Owner = Owner::findOrFail($id);
        $Owner->update($data);

        return $Owner;
    }
}

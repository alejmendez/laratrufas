<?php

namespace App\Services\Owners;

use App\Models\Owner;

class ListOwner
{
    public static function call($order = '', $search = '')
    {
        $owners = Owner::order($order)->search($search);

        return $owners;
    }
}

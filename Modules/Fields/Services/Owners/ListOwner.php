<?php

namespace Modules\Fields\Services\Owners;

use Modules\Fields\Models\Owner;
use Modules\Core\Services\PrimevueDatatables;

class ListOwner
{
    public static function call($params = [])
    {
        $searchableColumns = ['name', 'dni'];

        $query = Owner::query();

        $datatable = new PrimevueDatatables($params, $searchableColumns);
        $owners = $datatable->of($query)->make();

        return $owners;
    }
}

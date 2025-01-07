<?php

namespace Modules\Field\Services\Machineries;

use Modules\Field\Models\Machinery;
use Modules\Core\Services\PrimevueDatatables;

class ListMachinery
{
    public static function call($params = [])
    {
        $searchableColumns = ['name', 'purchase_date', 'last_maintenance', 'purchase_location', 'contact'];

        $query = Machinery::query();

        $datatable = new PrimevueDatatables($params, $searchableColumns);
        $plants = $datatable->of($query)->make();

        return $plants;
    }
}

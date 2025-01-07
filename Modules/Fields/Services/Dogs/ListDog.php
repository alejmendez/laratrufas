<?php

namespace Modules\Fields\Services\Dogs;

use Modules\Fields\Models\Dog;
use Modules\Core\Services\PrimevueDatatables;

class ListDog
{
    public static function call($params = [])
    {
        $searchableColumns = ['name', 'birthdate', 'quarter.name', 'gender', 'breed', 'veterinary', 'couple.full_name'];

        $query = Dog::query();

        $datatable = new PrimevueDatatables($params, $searchableColumns);
        $dogs = $datatable->of($query)->make();

        return $dogs;
    }
}

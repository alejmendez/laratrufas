<?php

namespace App\Services\Dogs;

use App\Models\Dog;
use App\Services\Primevue\PrimevueDatatables;

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

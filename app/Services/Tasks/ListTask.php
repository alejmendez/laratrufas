<?php

namespace App\Services\Tasks;

use App\Models\Task;
use App\Services\Primevue\PrimevueDatatables;

class ListTask
{
    public static function call($params)
    {
        $searchableColumns = ['name', 'status', 'priority', 'updated_at', 'responsible.full_name'];

        $query = Task::query();

        $datatable = new PrimevueDatatables($params, $searchableColumns);
        $dogs = $datatable->of($query)->make();

        return $dogs;
    }
}

<?php

namespace Modules\Tasks\Services;

use Modules\Core\Services\PrimevueDatatables;
use Modules\Tasks\Models\Task;

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

<?php

namespace Modules\Tasks\Services;

use Carbon\Carbon;
use Modules\Core\Services\PrimevueDatatables;
use Modules\Tasks\Models\Task;

class ListTask
{
    public static function call($params)
    {
        $searchableColumns = ['correlative', 'name', 'status', 'priority', 'updated_at', 'responsible.full_name'];
        $query = Task::query();

        $statusFilter = $params['filters']['status']['value']['value'] ?? null;

        $datatable = new PrimevueDatatables($params, $searchableColumns);
        $tasks = $datatable->of($query)->make();

        return $tasks;
    }
}

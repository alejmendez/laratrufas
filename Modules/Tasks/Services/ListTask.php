<?php

namespace Modules\Tasks\Services;

use Carbon\Carbon;
use Modules\Core\Services\PrimevueDatatables;
use Modules\Tasks\Models\Task;

class ListTask
{
    public static function call($params)
    {
        $searchableColumns = ['name', 'status', 'priority', 'updated_at', 'responsible.full_name'];
        $query = Task::query();

        $statusFilter = $params['filters']['status']['value']['value'] ?? null;

        if ($statusFilter === 'overdued') {
            unset($params['filters']['status']);
            $query->where('end_date', '<', now())
                  ->where('status', '!=', 'finished');
        } elseif ($statusFilter !== 'finished' && $statusFilter !== null) {
            $query->where('end_date', '>=', now());
        }

        $datatable = new PrimevueDatatables($params, $searchableColumns);
        $tasks = $datatable->of($query)->make();

        $today = now();
        $tasks->transform(function ($task) use ($today) {
            $endDate = Carbon::parse($task->end_date);
            $overdued = $today->diffInDays($endDate) < 0;
            $task->status = $overdued && $task->status !== 'finished' ? 'overdued' : $task->status;
            return $task;
        });

        return $tasks;
    }
}

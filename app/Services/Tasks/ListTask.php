<?php

namespace App\Services\Tasks;

use Illuminate\Support\Facades\DB;
use App\Models\Task;

class ListTask
{
    public static function call($order = '', $search = '')
    {
        $tasks = Task::select(
                'tasks.id',
                'tasks.name',
                'tasks.priority',
                'tasks.note',
                'tasks.updated_at',
                DB::raw("CONCAT(users.name, ' ', users.last_name) as responsible_name"),
            )
            ->join('users', 'tasks.responsible_id', '=', 'users.id')
            ->order($order);

        if ($search) {
            $tasks->whereAny([
                'tasks.name',
                'tasks.priority',
                'tasks.note',
                'users.name',
                'users.last_name',
            ], 'ILIKE', "%{$search}%");
        }

        return $tasks;
    }
}

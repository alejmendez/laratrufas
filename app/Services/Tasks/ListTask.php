<?php

namespace App\Services\Tasks;

use App\Models\Task;

class ListTask
{
    public static function call($order = '', $search = '')
    {
        $tasks = Task::order($order)->search($search);

        return $tasks;
    }
}

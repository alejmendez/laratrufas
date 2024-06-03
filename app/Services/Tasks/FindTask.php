<?php

namespace App\Services\Tasks;

use App\Models\Task;

class FindTask
{
    public static function call($id)
    {
        $task = Task::findOrFail($id);

        return $task;
    }
}

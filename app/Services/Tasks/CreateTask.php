<?php

namespace App\Services\Tasks;

use App\Models\Task;

class CreateTask
{
    public static function call($data): Task
    {
        $task = Task::create($data);
        return $task;
    }
}

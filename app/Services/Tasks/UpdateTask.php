<?php

namespace App\Services\Tasks;

use App\Models\Task;
use App\Models\TaskVaccine;

class UpdateTask
{
    public static function call($id, $data): Task
    {
        $task = Task::findOrFail($id);
        $task->update($data);

        return $task;
    }
}

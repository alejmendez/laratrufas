<?php

namespace App\Services\Tasks;

use App\Models\Task;

class DeleteTask
{
    public static function call($id): void
    {
        $task = Task::find($id);

        if ($task) {
            $task->comments()->delete();
            $task->delete();
        }
    }
}

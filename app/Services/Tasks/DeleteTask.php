<?php

namespace App\Services\Tasks;

use App\Models\Task;

class DeleteTask
{
    public static function call($id): void
    {
        Task::destroy($id);
    }
}

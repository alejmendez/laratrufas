<?php

namespace App\Services\Tasks;

use App\Models\Task;
use Modules\Users\Models\User;

class FindTask
{
    public static function call($id)
    {
        $task = Task::with('comments', 'responsible')->findOrFail($id);

        $current_user = auth()->user();
        if ($task->responsible && $task->responsible->id === $current_user->id) {
            $unreadNotifications = $task->responsible->unreadNotifications;
            $taskCurrentUserUnreadNotifications = $unreadNotifications->where('data.task_id', $current_user->id);
            foreach ($taskCurrentUserUnreadNotifications as $notification) {
                $notification->markAsRead();
            }
        }

        return $task;
    }
}

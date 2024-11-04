<?php

namespace App\Services\Tasks;

use App\Models\Task;
use App\Models\User;

class FindTask
{
    public static function call($id)
    {
        $task = Task::findOrFail($id);

        $user = User::find($task->responsible_id);
        $current_user = auth()->user();
        if ($user && $user->id === $current_user->id) {
            $unreadNotifications = $user->unreadNotifications;
            $taskCurrentUserUnreadNotifications = $unreadNotifications->where('data.task_id', $current_user->id);
            foreach ($taskCurrentUserUnreadNotifications as $notification) {
                $notification->markAsRead();
            }
        }

        return $task;
    }
}

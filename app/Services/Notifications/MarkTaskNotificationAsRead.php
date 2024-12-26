<?php

namespace App\Services\Notifications;

use App\Models\User;

class MarkTaskNotificationAsRead
{
    protected static $typeNotification = 'App\Notifications\TaskNotification';

    public static function call($task, $user)
    {
        $notifications = $user->notifications
            ->where('type', self::$typeNotification)
            ->whereNull('read_at')
            ->filter(function ($notification) use ($task) {
                return $notification->data['task_id'] === $task->id;
            });

        if ($notifications->isEmpty()) {
            return;
        }

        $notifications->markAsRead();
    }
}

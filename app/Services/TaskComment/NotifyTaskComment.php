<?php

namespace App\Services\TaskComment;

use App\Models\User;
use App\Models\Task;
use App\Models\TaskComment;
use App\Notifications\TaskNotification;

class NotifyTaskComment
{
    public static function call(Task $task, String | null $taskComment, User $commentator)
    {
        if (!$taskComment) {
            return;
        }

        $userIds = self::get_user_ids_from_comment($taskComment);
        $userIds[] = $task->responsible_id;
        $users = User::whereIn('id', array_unique($userIds))->get();

        foreach ($users as $user) {
            $user->notify(new TaskNotification([
                'task_id' => $task->id,
                'task_name' => $task->name,
                'task_comment' => strip_tags($taskComment),
                'notifier_user_id' => $commentator->id,
            ]));
        }
    }

    protected static function get_user_ids_from_comment($comment)
    {
        preg_match_all('/<span class="mention"[^>]*data-id="(\d+)"[^>]*>/', $comment, $matches);
        return $matches[1];
    }
}

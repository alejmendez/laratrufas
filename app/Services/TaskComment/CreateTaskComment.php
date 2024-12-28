<?php

namespace App\Services\TaskComment;

use App\Models\TaskComment;

class CreateTaskComment
{
    public static function call(array $data, User $user): TaskComment
    {
        $taskComment = new TaskComment();
        $taskComment->task_id = $data['task_id'];
        $taskComment->comment = $data['comment'];
        $taskComment->user_id = $user->id;
        $taskComment->save();

        return $taskComment;
    }
}

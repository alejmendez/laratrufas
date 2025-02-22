<?php

namespace Modules\Tasks\Services;

use Modules\Fields\Models\SupplyTask;
use Modules\Tasks\Models\Task;
use Modules\Tasks\Models\TaskComment;
use Modules\Tasks\Notifications\TaskNotification;
use Modules\Users\Models\User;

class CreateTask
{
    public static function call($data): Task
    {
        $task = new Task;

        $task->name = $data['name'];
        $task->status = $data['status']['value'];
        $task->repeat_number = '0';
        $task->repeat_type = '';
        $task->priority = $data['priority']['value'];
        $task->start_date = $data['start_date'];
        $task->end_date = $data['end_date'];
        $task->field_id = $data['field_id']['value'];
        $task->rows = collect($data['rows'])->map(fn ($q) => $q['value'])->toArray();
        $task->responsible_id = $data['responsible_id']['value'];
        $task->save();

        if (! empty($data['comment'])) {
            $comment = new TaskComment;
            $comment->comment = $data['comment'];
            $comment->user_id = auth()->id();
            $comment->task_id = $task->id;
            $comment->save();
        }

        self::syncRelationship($task, 'quarters', $data['quarter_id'] ?? []);
        self::syncRelationship($task, 'plants', $data['plant_id'] ?? []);
        self::syncRelationship($task, 'tools', $data['tools'] ?? []);
        self::syncRelationship($task, 'security_equipments', $data['security_equipments'] ?? []);
        self::syncRelationship($task, 'machineries', $data['machineries'] ?? []);

        self::saveSupplies($task, $data['supplies'] ?? []);

        self::notify($task, $data['comment'] ?? '');

        return $task;
    }

    protected static function syncRelationship($task, $relation, $data)
    {
        if (! empty($data)) {
            $ids = collect($data)->map(fn ($q) => $q['value'])->toArray();
            $task->{$relation}()->sync($ids);
        }
    }

    protected static function saveSupplies($task, $data)
    {
        foreach ($data as $supplyData) {
            if ($supplyData['name'] == null && $supplyData['brand'] == null && $supplyData['quantity'] == null && $supplyData['unit'] == null) {
                continue;
            }
            $supply = new SupplyTask;
            $supply->name = $supplyData['name'];
            $supply->brand = $supplyData['brand'];
            $supply->quantity = $supplyData['quantity'];
            $supply->unit = $supplyData['unit']['value'];
            $supply->task_id = $task->id;

            $supply->save();
        }
    }

    protected static function notify($task, $comment)
    {
        $current_user_id = auth()->id();
        $userIds = self::get_user_ids_from_comment($comment);
        $userIds[] = $task->responsible_id;
        $users = User::whereIn('id', array_unique($userIds))->get();

        foreach ($users as $user) {
            $user->notify(new TaskNotification([
                'task_id' => $task->id,
                'task_name' => $task->name,
                'task_comment' => strip_tags($comment),
                'notifier_user_id' => $current_user_id,
            ]));
        }
    }

    protected static function get_user_ids_from_comment($comment)
    {
        preg_match_all('/<span class="mention"[^>]*data-id="(\d+)"[^>]*>/', $comment, $matches);

        return $matches[1];
    }
}

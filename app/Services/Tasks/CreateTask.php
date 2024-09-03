<?php

namespace App\Services\Tasks;

use App\Models\Task;
use App\Models\SupplyTask;

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
        $task->rows = collect($data['rows'])->map(fn($q) => $q['value'])->toArray();
        $task->responsible_id = $data['responsible_id']['value'];
        $task->comments = $data['comments'];
        $task->save();

        self::syncRelationship($task, 'quarters', $data['quarter_id'] ?? []);
        self::syncRelationship($task, 'plants', $data['plant_id'] ?? []);
        self::syncRelationship($task, 'tools', $data['tools'] ?? []);
        self::syncRelationship($task, 'machineries', $data['machineries'] ?? []);

        self::saveSupplies($task, $data['supplies'] ?? []);

        return $task;
    }

    protected static function syncRelationship($task, $relation, $data)
    {
        if (!empty($data)) {
            $ids = collect($data)->map(fn($q) => $q['value'])->toArray();
            $task->{$relation}()->sync($ids);
        }
    }

    protected static function saveSupplies($task, $data)
    {
        foreach ($data as $supplyData) {
            $supply = new SupplyTask;
            $supply->name = $supplyData['name'];
            $supply->brand = $supplyData['brand'];
            $supply->quantity = $supplyData['quantity'];
            $supply->unit = $supplyData['unit']['value'];
            $supply->task_id = $task->id;

            $supply->save();
        }
    }
}

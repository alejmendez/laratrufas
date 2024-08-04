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
        $task->status = $data['status'];
        $task->repeat_number = $data['repeat_number'];
        $task->repeat_type = $data['repeat_type']['value'];
        $task->priority = $data['priority'];
        $task->start_date = $data['start_date'];
        $task->end_date = $data['end_date'];
        $task->field_id = $data['field_id']['value'];
        $task->quarter_id = $data['quarter_id']['value'];
        $task->plant_id = $data['plant_id']['value'];
        $task->responsible_id = $data['responsible_id']['value'];
        $task->comments = $data['comments'];
        $task->save();

        // Asignar herramientas
        if (!empty($data['tools'])) {
            $task->tools()->sync($data['tools']);
        }

        // Asignar equipos
        if (!empty($data['machineries'])) {
            $task->machineries()->sync($data['machineries']);
        }

        // Crear suministros
        if (!empty($data['supplies'])) {
            foreach ($data['supplies'] as $supply) {
                $supply_task = new SupplyTask;
                $supply_task->name = $supply['name'];
                $supply_task->brand = $supply['brand'];
                $supply_task->quantity = $supply['quantity'];
                $supply_task->unit = $supply['unit']['value'];
                $supply_task->task_id = $task->id;

                $supply_task->save();
            }
        }

        return $task;
    }
}

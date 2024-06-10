<?php

namespace App\Services\Tasks;

use App\Models\Task;

class CreateTask
{
    public static function call($data): Task
    {
        $task = Task::create([
            'name' => $data['name'],
            'status' => $data['status'],
            'repeat_number' => $data['repeat_number'],
            'repeat_type' => $data['repeat_type'],
            'priority' => $data['priority'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'field_id' => $data['field_id'],
            'quarter_id' => $data['quarter_id'],
            'plant_id' => $data['plant_id'],
            'responsible_id' => $data['responsible_id'],
            'comments' => $data['comments'],
        ]);

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
                SupplyTask::create([
                    'name' => $supply['name'],
                    'brand' => $supply['brand'],
                    'quantity' => $supply['quantity'],
                    'unit' => $supply['unit'],
                    'task_id' => $task->id,
                ]);
            }
        }

        return $task;
    }
}

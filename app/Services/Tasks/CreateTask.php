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
        $task->repeat_number = $data['repeat_number'];
        $task->repeat_type = $data['repeat_type']['value'];
        $task->priority = $data['priority']['value'];
        $task->start_date = $data['start_date'];
        $task->end_date = $data['end_date'];
        $task->field_id = $data['field_id']['value'];
        $task->rows = collect($data['rows'])->map(fn($q) => $q['value'])->toArray();
        $task->responsible_id = $data['responsible_id']['value'];
        $task->comments = $data['comments'];
        $task->save();

        // Asignar cuarteles
        if (!empty($data['quarter_id'])) {
            $quarter_ids = collect($data['quarter_id'])->map(fn($q) => $q['value'])->toArray();
            $task->quarters()->sync($quarter_ids);
        }

        // Asignar plantas
        if (!empty($data['plant_id'])) {
            $plant_ids = collect($data['plant_id'])->map(fn($q) => $q['value'])->toArray();
            $task->plants()->sync($plant_ids);
        }

        // Asignar herramientas
        if (!empty($data['tools'])) {
            $tool_ids = collect($data['tools'])->map(fn($q) => $q['value'])->toArray();
            $task->tools()->sync($tool_ids);
        }

        // Asignar equipos
        if (!empty($data['machineries'])) {
            $machinery_ids = collect($data['machineries'])->map(fn($q) => $q['value'])->toArray();
            $task->machineries()->sync($machinery_ids);
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

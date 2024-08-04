<?php

namespace App\Services\Tasks;

use App\Models\Task;
use App\Models\TaskVaccine;

class UpdateTask
{
    public static function call($id, $data): Task
    {
        $task = Task::findOrFail($id);

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

        $supplies = $data['supplies'] ?? [];

        self::save_supplies($supplies);

        return $task;
    }

    protected static function save_supplies($data) {
        $supplies = collect($data);

        $idSupplies = $dog->supplies()->pluck('id');
        $idSuppliesToDestroy = $idSupplies->filter(function ($id, int $key) use ($Supplies) {
            return !$Supplies->firstWhere('id', $id);
        })->toArray();

        SupplyTask::destroy($idSuppliesToDestroy);
        foreach ($supplies as $supply) {
            $supply = SupplyTask::firstOrNew('id', $supply['id']);
            $supply->name = $supply['name'];
            $supply->brand = $supply['brand'];
            $supply->quantity = $supply['quantity'];
            $supply->unit = $supply['unit']['value'];
            $supply->save();
        }
    }
}

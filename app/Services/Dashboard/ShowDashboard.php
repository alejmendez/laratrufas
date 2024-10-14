<?php

namespace App\Services\Dashboard;

use Illuminate\Support\Facades\DB;

use App\Models\Harvest;
use App\Models\Task;
use App\Services\Fields\FindField;
use App\Http\Resources\FieldResource;
use App\Services\Entities\ListEntity;

class ShowDashboard
{
    public static function call($id = null)
    {
        $current_user = auth()->user();
        $fields = ListEntity::call('field');
        $field = FindField::call($id ?? $fields[0]['value']);

        $quarter_ids = $field->quarters->pluck('id');
        $harvest_data = self::getHarvestData($quarter_ids);
        $task_data = self::getTaskData($current_user);

        return [
            'fields' => $fields,
            'field' => new FieldResource($field),
            'harvest_data' => $harvest_data,
            'task_data' => $task_data,
        ];
    }

    public static function getHarvestData($quarter_ids)
    {
        $current_year = date("Y");
        $last_year = $current_year - 1;

        $current_year_harvest_details = self::getHarvestDataByYear($current_year, $quarter_ids);
        $last_year_harvest_details = self::getHarvestDataByYear($last_year, $quarter_ids);

        $current_year_total_weight = $current_year_harvest_details->sum('weight_sum');
        $last_year_total_weight = $last_year_harvest_details->sum('weight_sum');
        $last_harvest_details = $current_year_harvest_details->first();

        if ($last_year_total_weight === 0) {
            $variation_between_harvests = 0;
        } else {
            $variation_between_harvests = round(($current_year_total_weight * 100 / $last_year_total_weight) - 100, 2);
        }

        return [
            'total_weight_of_last_harvest' => round($last_harvest_details->weight_sum / 1000, 2),
            'average_weight_per_plant' => round($last_harvest_details->weight_sum / $last_harvest_details->count_plants, 2),
            'variation_between_harvests' => $variation_between_harvests,
            'years_variation' => [$current_year, $last_year],
        ];
    }

    public static function getHarvestDataByYear($year, $quarter_ids)
    {
        return Harvest::leftJoin('harvest_details', 'harvests.id', '=', 'harvest_details.harvest_id')
            ->select('week', 'year', DB::raw('sum(harvest_details.weight) as weight_sum'), DB::raw('count(harvest_details.*) as count_plants'))
            ->whereIn('harvest_details.quarter_id', $quarter_ids)
            ->where('year', $year)
            ->groupBy('week', 'year')
            ->orderBy('year', 'desc')
            ->orderBy('week', 'desc')
            ->get();
    }

    public static function getTaskData($current_user)
    {
        $count_pending_tasks = Task::where([
            'responsible_id' => $current_user->id,
            'status' => 'to_begin',
        ])->count();

        $count_tasks_in_progress = Task::where([
            'responsible_id' => $current_user->id,
            'status' => 'started',
        ])->count();

        $count_total_task = Task::where('responsible_id', $current_user->id)
            ->whereIn('status', ['to_begin', 'started', 'stopped'])
            ->count();

        return [
            'pending_tasks' => $count_pending_tasks,
            'tasks_in_progress' => $count_tasks_in_progress,
            'tasks_totals' => $count_total_task,
        ];
    }
}

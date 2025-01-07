<?php

namespace Modules\Dashboard\Services;

use Modules\Tasks\Models\Task;

use App\Models\Harvest;
use App\Models\Liquidation;
use App\Services\Fields\FindField;
use App\Services\Entities\ListEntity;

class ShowDashboard
{
    public static function call($id = null)
    {
        $current_user = auth()->user();
        $fields = ListEntity::call('field');
        $field = FindField::call($id ?? $fields[0]['value']);

        $quarter_ids = $field->quarters->pluck('id');
        $harvest_data = self::getHarvestData($field, $quarter_ids);
        $task_data = self::getTaskData($current_user);

        return [
            'fields' => $fields,
            'field' => $field,
            'harvest_data' => $harvest_data,
            'task_data' => $task_data,
        ];
    }

    public static function getHarvestData($field, $quarter_ids)
    {
        $current_year = date("Y");
        $last_year = $current_year - 1;

        $current_year_harvest_details = self::getLiquidationDataByYear($current_year, $field);
        $last_year_harvest_details = self::getLiquidationDataByYear($last_year, $field);

        $current_year_total_weight = floatval($current_year_harvest_details->weight_sum);
        $last_year_total_weight = floatval($last_year_harvest_details->weight_sum);

        if ($current_year === '2024') {
            $last_year_total_weight = 86.23;
        }

        if ($last_year_total_weight === 0) {
            $variation_between_harvests = 0;
        } else {
            $variation_between_harvests = round(($current_year_total_weight * 100 / $last_year_total_weight) - 100, 2);
        }

        $average_weight_per_plant = 0;

        if ($field->plants_count > 0) {
            $average_weight_per_plant = round($current_year_total_weight * 1000 / $field->plants_count, 2);
        }

        return [
            'total_weight_of_last_harvest' => round($current_year_total_weight, 2),
            'average_weight_per_plant' => $average_weight_per_plant,
            'variation_between_harvests' => $variation_between_harvests,
            'years_variation' => [$current_year, $last_year],
        ];
    }

    public static function getLiquidationDataByYear($year, $field)
    {
        return Liquidation::leftJoin('liquidation_products', 'liquidations.id', '=', 'liquidation_products.liquidation_id')
            ->leftJoin('category_products', 'liquidation_products.category_product_id', '=', 'category_products.id')
            ->selectRaw('sum(liquidation_products.weight) as weight_sum')
            ->where('field_id', $field->id)
            ->where('year', $year)
            ->where('category_products.is_commercial', true)
            ->get()
            ->first();
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

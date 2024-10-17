<?php

namespace App\Services\Quarters;

use App\Models\Plant;
use App\Models\Harvest;
use App\Models\HarvestDetail;
use Illuminate\Support\Facades\DB;

class ListQuarterPlants
{
    public static function call($id)
    {
        $harvests = Harvest::whereHas('quarters', function($q) use ($id){
                $q->where('quarters.id', $id);
            })
            ->get()
            ->map(fn ($a) => $a->only(['id', 'year', 'week', 'date', 'batch']));

        $harvestDetails = HarvestDetail::with('harvest')->where('quarter_id', $id)->get();
        $maxWeight = HarvestDetail::where('quarter_id', $id)
            ->groupBy('plant_id')
            ->select(DB::raw('sum(weight) as weight'))
            ->get()
            ->max('weight');

        $maxWeight = floatval($maxWeight);

        $harvestDetailsByPlantId = $harvestDetails->groupBy('plant_id');

        $plants = Plant::select('id', 'code', 'row', 'position')
            ->where('quarter_id', $id)
            ->orderBy('id')
            ->get()
            ->map(function($plant) use ($harvestDetailsByPlantId, $maxWeight) {
                $plant->data = [];

                $detail = $harvestDetailsByPlantId->get($plant->id);
                $plant->scale = 0;
                if ($detail) {
                    $plant->scale = round($detail->sum('weight') * 100 / $maxWeight, 2);
                    $detail = $detail->map(fn ($a) => $a->only(['id', 'harvest_id', 'quality', 'weight']))
                        ->map(function ($a) use ($maxWeight) {
                            $a['weight'] = floatval($a['weight']);
                            $a['scale'] = round($a['weight'] * 100 / $maxWeight, 2);
                            return $a;
                        })
                        ->groupBy('harvest_id');
                }
                $plant->data = $detail;
                return $plant;
            });

        return [
            'harvests' => $harvests,
            'plants' => $plants,
        ];
    }
}

<?php

namespace App\Services\Quarters;

use App\Models\Plant;
use App\Models\Harvest;
use App\Models\HarvestDetail;

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
        $maxWeight = floatval($harvestDetails->max('weight'));
        $harvestDetailsByPlantId = $harvestDetails->groupBy('plant_id');

        $plants = Plant::select('id', 'code', 'row', 'position')
            ->where('quarter_id', $id)
            ->orderBy('id')
            ->get()
            ->map(function($plant) use ($harvestDetailsByPlantId, $maxWeight) {
                $plant->data = [];

                $detail = $harvestDetailsByPlantId->get($plant->id);
                if ($detail) {
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

<?php

namespace App\Services\Harvests;

use App\Models\Harvest;
use App\Services\Primevue\PrimevueDatatables;

class ListHarvest
{
    public static function call($params = [])
    {
        $query = Harvest::with('details', 'details.quarter', 'details.quarter.field', 'farmer')->withSum('details', 'weight')->withCount('details');

        $searchableColumns = ['year', 'batch', 'details.quarter.field.name', 'details.quarter.name', 'farmer.full_name'];

        $special_sort = false;
        $paramsCollection = collect($params);

        $perPage = $paramsCollection->get('rows', 10);
        $currentPage = $paramsCollection->get('page', 0) + 1;

        $filters = collect($paramsCollection->get('filters', []));
        $sort = $paramsCollection->get('sortField');
        $sortDirection = $paramsCollection->get('sortOrder') == 1 ? 'asc' : 'desc';
        if ($sort === 'total_weight' || $sort === 'unit_count') {
            $params['sortField'] = '';
            $params['sortOrder'] = '';
            $special_sort = true;
        }

        $datatable = new PrimevueDatatables($params, $searchableColumns);
        $harvestsQuery = $datatable->of($query)->make(true);
        $harvestsTotal = $harvestsQuery->clone()->reorder()->get();
        $details_count = $harvestsTotal->sum('details_count');
        $details_sum_weight = $harvestsTotal->sum('details_sum_weight');

        $harvests = $harvestsQuery->paginate($perPage, page: $currentPage);

        $harvestsCollection = $harvests->getCollection();

        $harvestsCollection->transform(function ($harvest) use ($filters) {
            $quarterFilter = collect($filters->get('details.quarter_id', []));
            $quarterId = $quarterFilter->get('value');

            $details = $harvest->details;
            if ($quarterId) {
                $details = $details->where('quarter_id', $quarterId);
            }

            $quarterNames = $details->map(fn ($detail) => $detail->quarter->name)->unique()->join(', ');
            // dd($quarterId);
            return [
                'id' => $harvest->id,
                'date' => $harvest->date,
                'year' => $harvest->year,
                'week' => $harvest->week,
                'batch' => $harvest->batch,
                'field_names' => $details->map(fn ($detail) => $detail->quarter->field->name)->unique()->join(', '),
                'quarter_names' => $details->map(fn ($detail) => $detail->quarter->name)->unique()->join(', '),
                'total_weight' => $details->map(fn ($detail) => $detail->weight)->sum(),
                'unit_count' => $details->count(),
                'farmer_name' => $harvest->farmer->name,
            ];
        });

        $harvestsArray = $harvests->toArray();

        if ($special_sort) {
            $data = collect($harvestsArray['data']);
            if ($sortDirection === 'asc') {
                $data = $data->sortBy($sort);
            } else {
                $data = $data->sortByDesc($sort);
            }
            $harvestsArray['data'] = $data->values();
            // dd($harvestsArray['data']);
        }

        $harvestsArray['details_count'] = $details_count;
        $harvestsArray['details_sum_weight'] = $details_sum_weight;

        return $harvestsArray;
    }
}

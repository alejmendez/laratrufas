<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use App\Services\Harvests\ListHarvest;
use App\Services\HarvestDetails\CreateHarvestDetails;
use App\Services\HarvestDetails\ListHarvestQualities;
use App\Services\Plants\FindPlantByCode;

use App\Http\Requests\StoreHarvestDetailRequest;

class HarvestDetailsController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('HarvestDetails/Create', [
            'qualities' => $this->getSelectQualities(),
            'plant_code' => session('plant_code'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHarvestDetailRequest $request)
    {
        CreateHarvestDetails::call($request->validated());
        if ($request->keep_plant_code) {
            return redirect()->route('harvests.details.create')->with('plant_code', $request->plant_code);
        } else {
            return redirect()->route('harvests.details.create');
        }

    }
    public function find_by_code()
    {
        return [
            'plant' => FindPlantByCode::call(request('code', '')),
        ];
    }

    protected function getSelectHarvests()
    {
        return collect(ListHarvest::call('batch')->get())
            ->map(fn($harvest) => [ 'id' => $harvest->id, 'batch' => $harvest->batch, 'date' => $harvest->date ]);
    }

    protected function getSelectQualities()
    {
        return ListHarvestQualities::call('select');
    }
}

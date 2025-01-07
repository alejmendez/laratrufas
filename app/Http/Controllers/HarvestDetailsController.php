<?php

namespace App\Http\Controllers;

use Modules\Core\Http\Controllers\Controller;
use App\Http\Requests\StoreHarvestDetailRequest;
use App\Services\HarvestDetails\CreateHarvestDetails;
use App\Services\HarvestDetails\ListHarvestQualities;
use App\Services\Plants\FindPlantByCode;
use Inertia\Inertia;

class HarvestDetailsController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('HarvestDetails/Create', [
            'qualities' => ListHarvestQualities::call('select'),
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
        $plant = FindPlantByCode::call(request('code', ''));
        return [
            'plant' => $plant,
            'details' => $plant->activeDetails()->pluck('value', 'type'),
        ];
    }
}

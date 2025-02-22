<?php

namespace Modules\Fields\Http\Controllers;

use Modules\Core\Http\Controllers\Controller;
use Modules\Fields\Http\Requests\StoreHarvestDetailRequest;
use Modules\Fields\Services\HarvestDetails\CreateHarvestDetails;
use Modules\Fields\Services\HarvestDetails\ListHarvestQualities;
use Modules\Fields\Services\Plants\FindPlantByCode;
use Inertia\Inertia;
use Modules\Core\Traits\HasPermissionMiddleware;

class HarvestDetailsController extends Controller
{
    use HasPermissionMiddleware;
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Fields::HarvestDetails/Create', [
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

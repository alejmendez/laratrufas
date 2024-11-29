<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlantDetailRequest;
use App\Services\PlantDetails\CreatePlantDetails;
use Inertia\Inertia;

class PlantDetailsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePlantDetailRequest $request)
    {
        CreatePlantDetails::call($request->validated());
        return redirect()->route('harvests.details.create');
    }
}

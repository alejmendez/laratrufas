<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use App\Services\Harvests\ListHarvest;
use App\Services\HarvestDetails\CreateHarvestDetails;


class HarvestDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('HarvestDetails/Create', [
            'harvests' => $this->getSelectHarvests(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHarvestRequest $request)
    {
        CreateHarvestDetails::call($request->validated());

        return redirect()->route('harvests.index')->with('toast', 'Harvest created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHarvestRequest $request, string $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    }

    protected function getSelectHarvests()
    {
        return collect(ListHarvest::call('batch')->get())
            ->map(fn($harvest) => [ 'id' => $harvest->id, 'batch' => $harvest->batch, 'date' => $harvest->date ]);
    }
}

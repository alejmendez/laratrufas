<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use App\Services\Harvests\FindHarvest;
use App\Services\Harvests\ListHarvest;
use App\Services\Harvests\CreateHarvest;
use App\Services\Harvests\UpdateHarvest;
use App\Services\Harvests\DeleteHarvest;

use App\Http\Resources\HarvestResource;
use App\Http\Resources\HarvestCollection;
use App\Http\Requests\StoreHarvestRequest;
use App\Http\Requests\UpdateHarvestRequest;

class HarvestsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order = request('order', '');
        $search = request('search', '');
        $harvests = ListHarvest::call($order, $search);

        return Inertia::render('Harvests/List', [
            'order' => $order,
            'search' => $search,
            'toast' => session('toast'),
            'data' => new HarvestCollection($harvests->paginate()->withQueryString()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Harvests/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHarvestRequest $request)
    {
        CreateHarvest::call($request->all());

        return redirect()->route('Harvests.index')->with('toast', 'Harvest created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $harvest = FindHarvest::call($id);

        return Inertia::render('Harvests/Show', [
            'data' => new HarvestResource($harvest),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $harvest = FindHarvest::call($id);

        return Inertia::render('Harvests/Edit', [
            'data' => new HarvestResource($harvest),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHarvestRequest $request, string $id)
    {
        UpdateHarvest::call($id, $request->all());

        return redirect()->route('Harvests.index')->with('toast', 'Harvest updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DeleteHarvest::call($id);
        return redirect()->back();
    }
}

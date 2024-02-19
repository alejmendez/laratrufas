<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use App\Services\Plants\FindPlant;
use App\Services\Plants\ListPlant;
use App\Services\Plants\CreatePlant;
use App\Services\Plants\UpdatePlant;
use App\Services\Plants\DeletePlant;

use App\Http\Resources\PlantResource;
use App\Http\Resources\PlantCollection;
use App\Http\Requests\StorePlantRequest;
use App\Http\Requests\UpdatePlantRequest;

class PlantsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order = request('order', '');
        $search = request('search', '');
        $plants = ListPlant::call($order, $search);

        return Inertia::render('Plants/List', [
            'order' => $order,
            'search' => $search,
            'toast' => session('toast'),
            'data' => new PlantCollection($plants->paginate()->withQueryString()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Plants/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePlantRequest $request)
    {
        $data = $request->all();
        $data['blueprint'] = $this->storeBlueprint($request);
        CreatePlant::call($data);

        return redirect()->route('plants.index')->with('toast', 'Plant created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Plant = FindPlant::call($id);

        return Inertia::render('Plants/Edit', [
            'data' => new PlantResource($Plant),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $Plant = FindPlant::call($id);

        return Inertia::render('Plants/Edit', [
            'data' => new PlantResource($user),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePlantRequest $request, string $id)
    {
        $data = $request->all();
        $data['blueprint'] = $this->storeBlueprint($request);
        UpdatePlant::call($id, $data);

        return redirect()->route('plants.index')->with('toast', 'Plant updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DeletePlant::call($id);
        return redirect()->back();
    }

    protected function storeBlueprint(UpdatePlantRequest | StorePlantRequest $request)
    {
        if (!$request->hasFile('blueprint')) {
            return null;
        }

        return $request->file('blueprint')->store(options: 'blueprints');
    }
}

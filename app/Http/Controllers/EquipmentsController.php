<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use App\Services\Equipments\FindEquipment;
use App\Services\Equipments\ListEquipment;
use App\Services\Equipments\CreateEquipment;
use App\Services\Equipments\UpdateEquipment;
use App\Services\Equipments\DeleteEquipment;

use App\Http\Resources\EquipmentResource;
use App\Http\Resources\EquipmentCollection;
use App\Http\Requests\StoreEquipmentRequest;
use App\Http\Requests\UpdateEquipmentRequest;

class EquipmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order = request('order', '');
        $search = request('search', '');
        $equipments = ListEquipment::call($order, $search);

        return Inertia::render('Equipments/List', [
            'order' => $order,
            'search' => $search,
            'toast' => session('toast'),
            'data' => new EquipmentCollection($equipments->paginate()->withQueryString()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Equipments/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEquipmentRequest $request)
    {
        CreateEquipment::call($request->validated());

        return redirect()->route('equipments.index')->with('toast', 'Equipment created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $equipment = FindEquipment::call($id);

        return Inertia::render('Equipments/Show', [
            'data' => new EquipmentResource($equipment),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $equipment = FindEquipment::call($id);

        return Inertia::render('Equipments/Edit', [
            'data' => new EquipmentResource($equipment),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEquipmentRequest $request, string $id)
    {
        UpdateEquipment::call($id, $request->validated());

        return redirect()->route('equipments.index')->with('toast', 'Equipment updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DeleteEquipment::call($id);
        return redirect()->back();
    }
}

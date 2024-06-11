<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use App\Services\Machineries\FindMachinery;
use App\Services\Machineries\ListMachinery;
use App\Services\Machineries\CreateMachinery;
use App\Services\Machineries\UpdateMachinery;
use App\Services\Machineries\DeleteMachinery;

use App\Http\Resources\MachineryResource;
use App\Http\Resources\MachineryCollection;
use App\Http\Requests\StoreMachineryRequest;
use App\Http\Requests\UpdateMachineryRequest;

class MachineriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order = request('order', '');
        $search = request('search', '');
        $machineries = ListMachinery::call($order, $search);

        return Inertia::render('Machineries/List', [
            'order' => $order,
            'search' => $search,
            'toast' => session('toast'),
            'data' => new MachineryCollection($machineries->paginate()->withQueryString()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Machineries/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMachineryRequest $request)
    {
        CreateMachinery::call($request->validated());

        return redirect()->route('machineries.index')->with('toast', 'Machinery created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $machinery = FindMachinery::call($id);

        return Inertia::render('Machineries/Show', [
            'data' => new MachineryResource($machinery),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $machinery = FindMachinery::call($id);

        return Inertia::render('Machineries/Edit', [
            'data' => new MachineryResource($machinery),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMachineryRequest $request, string $id)
    {
        UpdateMachinery::call($id, $request->validated());

        return redirect()->route('machineries.index')->with('toast', 'Machinery updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DeleteMachinery::call($id);
        return redirect()->back();
    }
}

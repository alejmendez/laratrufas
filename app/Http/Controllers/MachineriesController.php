<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMachineryRequest;
use App\Http\Requests\UpdateMachineryRequest;
use App\Http\Resources\MachineryResource;
use App\Services\Machineries\CreateMachinery;
use App\Services\Machineries\DeleteMachinery;
use App\Services\Machineries\FindMachinery;
use App\Services\Machineries\ListMachinery;
use App\Services\Machineries\UpdateMachinery;
use Inertia\Inertia;

class MachineriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->exists('dt_params')) {
            $params = json_decode(request('dt_params', '[]'), true);

            return response()->json(ListMachinery::call($params));
        }

        return Inertia::render('Machineries/List', [
            'toast' => session('toast'),
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

        return response()->noContent();
    }
}

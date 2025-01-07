<?php

namespace App\Http\Controllers;

use Modules\Core\Http\Controllers\Controller;
use App\Http\Requests\StoreSecurityEquipmentRequest;
use App\Http\Requests\UpdateSecurityEquipmentRequest;
use App\Http\Resources\SecurityEquipmentResource;
use App\Services\SecurityEquipments\CreateSecurityEquipment;
use App\Services\SecurityEquipments\DeleteSecurityEquipment;
use App\Services\SecurityEquipments\FindSecurityEquipment;
use App\Services\SecurityEquipments\ListSecurityEquipment;
use App\Services\SecurityEquipments\UpdateSecurityEquipment;
use Inertia\Inertia;

class SecurityEquipmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->exists('dt_params')) {
            $params = json_decode(request('dt_params', '[]'), true);

            return response()->json(ListSecurityEquipment::call($params));
        }

        return Inertia::render('SecurityEquipments/List', [
            'toast' => session('toast'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('SecurityEquipments/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSecurityEquipmentRequest $request)
    {
        CreateSecurityEquipment::call($request->validated());

        return redirect()->route('security_equipments.index')->with('toast', 'SecurityEquipment created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $security_equipment = FindSecurityEquipment::call($id);

        return Inertia::render('SecurityEquipments/Show', [
            'data' => new SecurityEquipmentResource($security_equipment),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $security_equipment = FindSecurityEquipment::call($id);

        return Inertia::render('SecurityEquipments/Edit', [
            'data' => new SecurityEquipmentResource($security_equipment),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSecurityEquipmentRequest $request, string $id)
    {
        UpdateSecurityEquipment::call($id, $request->validated());

        return redirect()->route('security_equipments.index')->with('toast', 'SecurityEquipment updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DeleteSecurityEquipment::call($id);

        return response()->noContent();
    }
}

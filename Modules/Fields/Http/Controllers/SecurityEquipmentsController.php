<?php

namespace Modules\Fields\Http\Controllers;

use Modules\Core\Http\Controllers\Controller;
use Modules\Fields\Http\Requests\StoreSecurityEquipmentRequest;
use Modules\Fields\Http\Requests\UpdateSecurityEquipmentRequest;
use Modules\Fields\Http\Resources\SecurityEquipmentResource;
use Modules\Fields\Services\SecurityEquipments\CreateSecurityEquipment;
use Modules\Fields\Services\SecurityEquipments\DeleteSecurityEquipment;
use Modules\Fields\Services\SecurityEquipments\FindSecurityEquipment;
use Modules\Fields\Services\SecurityEquipments\ListSecurityEquipment;
use Modules\Fields\Services\SecurityEquipments\UpdateSecurityEquipment;
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

        return Inertia::render('Fields::SecurityEquipments/List', [
            'toast' => session('toast'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Fields::SecurityEquipments/Create');
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

        return Inertia::render('Fields::SecurityEquipments/Show', [
            'data' => new SecurityEquipmentResource($security_equipment),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $security_equipment = FindSecurityEquipment::call($id);

        return Inertia::render('Fields::SecurityEquipments/Edit', [
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

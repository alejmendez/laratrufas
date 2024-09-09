<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLiquidationRequest;
use App\Http\Requests\UpdateLiquidationRequest;
use App\Http\Resources\LiquidationResource;
use App\Services\Entities\ListEntity;
use App\Services\Liquidations\CreateLiquidation;
use App\Services\Liquidations\DeleteLiquidation;
use App\Services\Liquidations\FindLiquidation;
use App\Services\Liquidations\ListLiquidation;
use App\Services\Liquidations\UpdateLiquidation;
use Inertia\Inertia;

class LiquidationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->exists('dt_params')) {
            $params = json_decode(request('dt_params', '[]'), true);

            return response()->json(ListLiquidation::call($params));
        }

        return Inertia::render('Liquidations/List', [
            'toast' => session('toast'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Liquidations/Create', [
            'importers' => ListEntity::call('importer'),
            'category_products' => ListEntity::call('category_products'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLiquidationRequest $request)
    {
        CreateLiquidation::call($request->validated());

        return redirect()->route('liquidations.index')->with('toast', 'Liquidation created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $liquidation = FindLiquidation::call($id);

        return Inertia::render('Liquidations/Show', [
            'importers' => ListEntity::call('importer'),
            'category_products' => ListEntity::call('category_products'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $liquidation = FindLiquidation::call($id);

        return Inertia::render('Liquidations/Edit', [
            'data' => new LiquidationResource($liquidation),
            'importers' => ListEntity::call('importer'),
            'category_products' => ListEntity::call('category_products'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLiquidationRequest $request, string $id)
    {
        UpdateLiquidation::call($id, $request->validated());

        return redirect()->route('liquidations.index')->with('toast', 'Liquidation updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DeleteLiquidation::call($id);

        return response()->noContent();
    }
}

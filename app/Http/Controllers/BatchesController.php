<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBatchRequest;
use App\Http\Requests\UpdateBatchRequest;
use App\Http\Resources\BatchResource;
use App\Services\Batches\CreateBatch;
use App\Services\Batches\DeleteBatch;
use App\Services\Batches\FindBatch;
use App\Services\Batches\ListBatch;
use App\Services\Batches\UpdateBatch;
use App\Services\Entities\ListEntity;
use Inertia\Inertia;

class BatchesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->exists('dt_params')) {
            $params = json_decode(request('dt_params', '[]'), true);

            return response()->json(ListBatch::call($params));
        }

        return Inertia::render('Batches/List', [
            'toast' => session('toast'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Batches/Create', [
            'importers' => ListEntity::call('importer'),
            'harvests' => ListEntity::call('harvest'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBatchRequest $request)
    {
        CreateBatch::call($request->validated());

        return redirect()->route('batches.index')->with('toast', 'Batch created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $batch = FindBatch::call($id);

        return Inertia::render('Batches/Show', [
            'importers' => ListEntity::call('importer'),
            'harvests' => ListEntity::call('harvest'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $batch = FindBatch::call($id);

        return Inertia::render('Batches/Edit', [
            'data' => new BatchResource($batch),
            'importers' => ListEntity::call('importer'),
            'harvests' => ListEntity::call('harvest'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBatchRequest $request, string $id)
    {
        UpdateBatch::call($id, $request->validated());

        return redirect()->route('batches.index')->with('toast', 'Batch updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DeleteBatch::call($id);

        return response()->noContent();
    }
}

<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use App\Services\Fields\FindField;
use App\Services\Fields\ListField;
use App\Services\Fields\CreateField;
use App\Services\Fields\UpdateField;
use App\Services\Fields\DeleteField;

use App\Services\Harvests\ListHarvest;

use App\Http\Resources\FieldResource;
use App\Http\Resources\FieldCollection;
use App\Http\Requests\StoreFieldRequest;
use App\Http\Requests\UpdateFieldRequest;

class FieldsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->exists('dt_params')) {
            $params = json_decode(request('dt_params', '[]'), true);
            return response()->json(ListField::call($params));
        }

        return Inertia::render('Fields/List', [
            'toast' => session('toast'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Fields/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFieldRequest $request)
    {
        $data = $request->validated();
        $data['blueprint'] = $this->storeBlueprint($request);
        CreateField::call($data);

        return redirect()->route('fields.index')->with('toast', 'Field created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = request('order', '');
        $search = request('search', '');
        $current_tab = request('current_tab', 'file');
        $field = FindField::call($id);

        return Inertia::render('Fields/Show', [
            'current_tab' => $current_tab,
            'field' => new FieldResource($field),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $field = FindField::call($id);

        return Inertia::render('Fields/Edit', [
            'data' => new FieldResource($field),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFieldRequest $request, string $id)
    {
        $data = $request->validated();
        $data['blueprint'] = $this->storeBlueprint($request);
        UpdateField::call($id, $data);

        return redirect()->route('fields.index')->with('toast', 'Field updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DeleteField::call($id);
        return response()->noContent();
    }

    protected function storeBlueprint(UpdateFieldRequest | StoreFieldRequest $request)
    {
        if ($request->file('blueprint') != null) {
            return null;
        }

        return $request->file('blueprint')->storePublicly('public/blueprints');
    }
}

<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use App\Services\Fields\FindField;
use App\Services\Fields\ListField;
use App\Services\Fields\CreateField;
use App\Services\Fields\UpdateField;
use App\Services\Fields\DeleteField;

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
        $order = request('order', '');
        $search = request('search', '');
        $fields = ListField::call($order, $search);

        return Inertia::render('Fields/List', [
            'order' => $order,
            'search' => $search,
            'toast' => session('toast'),
            'data' => new FieldCollection($fields->paginate()->withQueryString()),
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
        $field = FindField::call($id);

        return Inertia::render('Fields/Show', [
            'data' => new FieldResource($field),
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
        return redirect()->back();
    }

    protected function storeBlueprint(UpdateFieldRequest | StoreFieldRequest $request)
    {
        if (!$request->hasFile('blueprint')) {
            return null;
        }

        return $request->file('blueprint')->store(options: 'blueprints');
    }
}

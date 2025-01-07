<?php

namespace Modules\Field\Http\Controllers;

use Modules\Core\Http\Controllers\Controller;
use Modules\Field\Http\Requests\StoreFieldRequest;
use Modules\Field\Http\Requests\UpdateFieldRequest;
use Modules\Field\Http\Resources\FieldResource;
use Modules\Field\Services\Fields\CreateField;
use Modules\Field\Services\Fields\DeleteField;
use Modules\Field\Services\Fields\FindField;
use Modules\Field\Services\Fields\ListField;
use Modules\Field\Services\Fields\UpdateField;
use Inertia\Inertia;

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

        return Inertia::render('Fields::List', [
            'toast' => session('toast'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Fields::Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFieldRequest $request)
    {
        $data = $request->validated();
        $data['blueprint'] = $this->storeBlueprint($request);
        $data['documents'] = $this->storeDocuments($request);
        CreateField::call($data);

        return redirect()->route('fields.index')->with('toast', 'Field created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $current_tab = request('current_tab', 'file');
        $field = FindField::call($id);

        return Inertia::render('Fields::Show', [
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

        return Inertia::render('Fields::Edit', [
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
        $data['documents'] = $this->storeDocuments($request);
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

    protected function storeBlueprint(UpdateFieldRequest|StoreFieldRequest $request)
    {
        if ($request->file('blueprint') == null) {
            return null;
        }

        return $request->file('blueprint')->storePublicly('public/blueprints');
    }

    protected function storeDocuments(UpdateFieldRequest|StoreFieldRequest $request)
    {
        if ($request->file('documents') == null) {
            return null;
        }

        $documents = $request->file('documents');
        $documentStore = [];
        foreach ($documents as $document) {
            $documentStore[] = [
                'path' => $document->storePublicly('public/documents'),
                'name' => $document->getClientOriginalName(),
                'type' => $document->getClientMimeType(),
            ];
        }

        return $documentStore;
    }
}

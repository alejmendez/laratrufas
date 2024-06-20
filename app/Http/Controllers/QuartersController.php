<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use App\Services\Quarters\FindQuarter;
use App\Services\Quarters\ListQuarter;
use App\Services\Quarters\CreateQuarter;
use App\Services\Quarters\UpdateQuarter;
use App\Services\Quarters\DeleteQuarter;
use App\Services\Fields\ListField;
use App\Services\Entities\ListEntity;

use App\Http\Resources\QuarterResource;
use App\Http\Resources\QuarterCollection;
use App\Http\Requests\StoreQuarterRequest;
use App\Http\Requests\UpdateQuarterRequest;

class QuartersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order = request('order', '');
        $search = request('search', '');
        $quarters = ListQuarter::call($order, $search);

        return Inertia::render('Quarters/List', [
            'order' => $order,
            'search' => $search,
            'toast' => session('toast'),
            'data' => $quarters->paginate()->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Quarters/Create', [
            'fields' => ListEntity::call('field'),
            'responsibles' => ListEntity::call('responsible'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuarterRequest $request)
    {
        $data = $request->validated();
        $data['blueprint'] = $this->storeBlueprint($request);
        CreateQuarter::call($data);

        return redirect()->route('quarters.index')->with('toast', 'Quarter created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $quarter = FindQuarter::call($id);

        return Inertia::render('Quarters/Show', [
            'data' => new QuarterResource($quarter),
            'fields' => ListEntity::call('field'),
            'responsibles' => ListEntity::call('responsible'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $quarter = FindQuarter::call($id);

        return Inertia::render('Quarters/Edit', [
            'data' => new QuarterResource($quarter),
            'fields' => ListEntity::call('field'),
            'responsibles' => ListEntity::call('responsible'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuarterRequest $request, string $id)
    {
        $data = $request->validated();
        $data['blueprint'] = $this->storeBlueprint($request);
        UpdateQuarter::call($id, $data);

        return redirect()->route('quarters.index')->with('toast', 'Quarter updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DeleteQuarter::call($id);
        return redirect()->back();
    }

    protected function storeBlueprint(UpdateQuarterRequest | StoreQuarterRequest $request)
    {
        if (!$request->hasFile('blueprint')) {
            return null;
        }

        return $request->file('blueprint')->storePublicly('public/blueprints');
    }
}

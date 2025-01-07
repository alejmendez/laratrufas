<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Modules\Core\Http\Controllers\Controller;
use App\Services\Entities\ListEntity;
use App\Services\Quarters\FindQuarter;
use App\Services\Quarters\ListQuarter;
use App\Http\Resources\QuarterResource;
use App\Services\Quarters\CreateQuarter;
use App\Services\Quarters\DeleteQuarter;
use App\Services\Quarters\UpdateQuarter;
use App\Http\Requests\StoreQuarterRequest;
use App\Http\Requests\UpdateQuarterRequest;
use App\Services\Quarters\ListQuarterPlants;
use App\Services\Quarters\PlantsUpdatePositionQuarter;

class QuartersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->exists('dt_params')) {
            $params = json_decode(request('dt_params', '[]'), true);

            return response()->json(ListQuarter::call($params));
        }

        return Inertia::render('Quarters/List', [
            'toast' => session('toast'),
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

        return response()->noContent();
    }

    public function plants(string $id)
    {
        return response()->json(ListQuarterPlants::call($id));
    }

    public function plants_update_position(string $id)
    {
        PlantsUpdatePositionQuarter::call($id, request('data', []));

        return response()->noContent();
    }

    protected function storeBlueprint(UpdateQuarterRequest|StoreQuarterRequest $request)
    {
        if ($request->file('blueprint') == null) {
            return null;
        }

        return $request->file('blueprint')->storePublicly('public/blueprints');
    }
}

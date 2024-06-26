<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

use App\Services\Plants\FindPlant;
use App\Services\Plants\ListPlant;
use App\Services\Plants\CreatePlant;
use App\Services\Plants\UpdatePlant;
use App\Services\Plants\DeletePlant;
use App\Services\Fields\ListField;
use App\Services\Quarters\ListQuarter;
use App\Services\Entities\ListEntity;

use App\Http\Resources\PlantResource;
use App\Http\Resources\PlantCollection;
use App\Http\Requests\StorePlantRequest;
use App\Http\Requests\UpdatePlantRequest;
use App\Http\Requests\BulkPlantRequest;

use App\Imports\PlantsImport;
use App\Exports\PlantsTemplateExport;

class PlantsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order = request('order', '');
        $search = request('search', '');
        $plants = ListPlant::call($order, $search);

        return Inertia::render('Plants/List', [
            'order' => $order,
            'search' => $search,
            'toast' => session('toast'),
            'data' => $plants->paginate()->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Plants/Create', [
            'types' => ListEntity::call('plant_type'),
            'fields' => ListEntity::call('field'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePlantRequest $request)
    {
        $data = $request->validated();
        CreatePlant::call($data);

        return redirect()->route('plants.index')->with('toast', 'Plant created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $plant = FindPlant::call($id);

        return Inertia::render('Plants/Show', [
            'data' => new PlantResource($plant),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $plant = FindPlant::call($id);

        return Inertia::render('Plants/Edit', [
            'data' => new PlantResource($plant),
            'types' => ListEntity::call('plant_type'),
            'fields' => ListEntity::call('field'),
            'quarters' => ListEntity::call('quarter', ['field_id' => $plant->quarter->field_id]),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePlantRequest $request, string $id)
    {
        $data = $request->validated();
        UpdatePlant::call($id, $data);

        return redirect()->route('plants.index')->with('toast', 'Plant updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DeletePlant::call($id);
        return redirect()->route('plants.index');
    }

    public function download_bulk_template()
    {
        return Excel::download(new PlantsTemplateExport(), 'carga_masiva_plantas.xlsx');
    }

    public function create_bulk()
    {
        return Inertia::render('Plants/Bulk/Create', [
            'fields' => ListEntity::call('field'),
            'alert' => session('alert'),
            'errors' => session('errors', []),
        ]);
    }

    public function store_bulk(BulkPlantRequest $request)
    {
        try {
            $file = request()->file('bulk_file');
            $quarter_id = $request['quarter_id'];
            $result = Excel::import(new PlantsImport($quarter_id), $file);
            $rowCount = session('rowCount', 0);
            return redirect()
                ->route('plants.create.bulk')
                ->with('alert', "La carga de datos ha sido completada con éxito. Se han ingresado $rowCount registros de tipo de datos al sistema. ¡Buen trabajo!");
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errors = [];
            foreach ($failures as $failure) {
                foreach ($failure->errors() as $error) {
                    $errors[] = "Linea {$failure->row()}: {$error}";
                }
            }
            return redirect()->route('plants.create.bulk')->with('errors', $errors);
        } catch (Exception $e) {
            return redirect()->route('plants.create.bulk')->with('errors', []);
        }
    }
}

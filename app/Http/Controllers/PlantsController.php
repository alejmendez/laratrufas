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
        if (request()->exists('dt_params')) {
            $params = json_decode(request('dt_params', '[]'), true);
            return response()->json(ListPlant::call($params));
        }

        return Inertia::render('Plants/List', [
            'toast' => session('toast'),
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
            'message_success' => session('message_success', ''),
            'unprocessed_message' => session('unprocessed_message', ''),
            'error_message' => session('error_message', ''),
            'errors' => session('errors', []),
        ]);
    }

    public function store_bulk(BulkPlantRequest $request)
    {
        $file = request()->file('bulk_file');
        $quarter_id = $request['quarter_id']['value'];

        $import = new PlantsImport($quarter_id);
        $import->import($file);

        $errors = [];
        foreach ($import->failures() as $failure) {
            foreach ($failure->errors() as $error) {
                $errors[] = "Linea {$failure->row()}: {$error}";
            }
        }

        $rowCount = $import->getRowCount();
        $countErrors = count($errors);
        $numberOfUnprocessedRecords = $import->getNumberOfUnprocessedRecords();

        $message_success = "";
        if ($countErrors > 0) {
            $message_success = "Se han ingresado $rowCount registros al sistema y se tienen $countErrors errores.";
        } else {
            $message_success = "La carga de datos ha sido completada con éxito. Se han ingresado $rowCount registros de tipo de datos al sistema. ¡Buen trabajo!";
        }

        $error_message = "";
        if ($countErrors > 0) {
            $error_message = "Hay $countErrors errores o advertencias que debes corregir. Puedes ver el detalle de los errores en el resumen de la carga.";
        }

        $unprocessed_message = "";
        if ($numberOfUnprocessedRecords > 0) {
            $unprocessed_message = "Hay $numberOfUnprocessedRecords que no tienen errores pero no fueron procesados porque ya existen.";
        }

        return redirect()
            ->route('plants.create.bulk')
            ->with('message_success', $message_success)
            ->with('unprocessed_message', $unprocessed_message)
            ->with('error_message', $error_message)
            ->with('errors', $errors);
    }
}

<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

use App\Services\Harvests\FindHarvest;
use App\Services\Harvests\ListHarvest;
use App\Services\Harvests\CreateHarvest;
use App\Services\Harvests\UpdateHarvest;
use App\Services\Harvests\DeleteHarvest;
use App\Services\HarvestDetails\ListHarvestQualities;

use App\Services\Quarters\ListQuarter;
use App\Services\Dogs\ListDog;
use App\Services\Entities\ListEntity;

use App\Http\Resources\HarvestResource;
use App\Http\Resources\HarvestListCollection;
use App\Http\Requests\StoreHarvestRequest;
use App\Http\Requests\UpdateHarvestRequest;
use App\Http\Requests\BulkHarvestRequest;

use App\Imports\HarvestsImport;
use App\Exports\HarvestsTemplateExport;

class HarvestsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->exists('dt_params')) {
            $params = json_decode(request('dt_params', '[]'), true);
            $paramsCollection = collect($params);

            $harvests = ListHarvest::call($params);
            $harvests->getCollection()->transform(function ($harvest) {
                return [
                    'id' => $harvest->id,
                    'date' => $harvest->date,
                    'year' => $harvest->year,
                    'week' => $harvest->week,
                    'batch' => $harvest->batch,
                    'field_names' => $harvest->quarters->map(fn ($quarter) => $quarter->field->name)->unique()->join(', '),
                    'quarter_names' => $harvest->quarters->map(fn ($quarter) => $quarter->name)->unique()->join(', '),
                    'total_weight' => $harvest->details->map(fn ($detail) => $detail->weight)->sum(),
                    'unit_count' => $harvest->details->count(),
                    'farmer_name' => $harvest->farmer->name,
                ];
            });
            return response()->json($harvests);
        }

        return Inertia::render('Harvests/List', [
            'toast' => session('toast'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Harvests/Create', [
            'quarters' => ListEntity::call('quarterMultiselect'),
            'dogs' => ListEntity::call('dog'),
            'users' => ListEntity::call('user'),
            'plant_codes' => ListEntity::call('plant'),
            'qualities' => ListHarvestQualities::call('select'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHarvestRequest $request)
    {
        CreateHarvest::call($request->validated());

        return redirect()->route('harvests.index')->with('toast', 'Harvest created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $harvest = FindHarvest::call($id);

        return Inertia::render('Harvests/Show', [
            'data' => new HarvestResource($harvest),
            'quarters' => ListEntity::call('quarterMultiselect'),
            'dogs' => ListEntity::call('dog'),
            'users' => ListEntity::call('user'),
            'plant_codes' => ListEntity::call('plant'),
            'qualities' => ListHarvestQualities::call('select'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $harvest = FindHarvest::call($id);

        return Inertia::render('Harvests/Edit', [
            'data' => new HarvestResource($harvest),
            'quarters' => ListEntity::call('quarterMultiselect'),
            'dogs' => ListEntity::call('dog'),
            'users' => ListEntity::call('user'),
            'plant_codes' => ListEntity::call('plant'),
            'qualities' => ListHarvestQualities::call('select'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHarvestRequest $request, string $id)
    {
        UpdateHarvest::call($id, $request->validated());

        return redirect()->route('harvests.index')->with('toast', 'Harvest updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DeleteHarvest::call($id);
        return response()->noContent();
    }

    public function download_bulk_template()
    {
        return Excel::download(new HarvestsTemplateExport(), 'carga_masiva_cosecha.xlsx');
    }

    public function create_bulk()
    {
        return Inertia::render('Harvests/Bulk/Create', [
            'harvests' => ListEntity::call('harvest'),
            'id' => request('id'),
            'message_success' => session('message_success', ''),
            'unprocessed_message' => session('unprocessed_message', ''),
            'unprocessed_details' => session('unprocessed_details', []),
            'error_message' => session('error_message', ''),
            'errors' => session('errors', []),
        ]);
    }

    public function store_bulk(BulkHarvestRequest $request)
    {
        $file = request()->file('bulk_file');
        $harvest_id = $request['harvest_id']['value'];

        $import = new HarvestsImport($harvest_id);
        $import->import($file);

        $errors = [];
        foreach ($import->failures() as $failure) {
            foreach ($failure->errors() as $error) {
                $errors[] = "Linea {$failure->row()}: {$error}";
            }
        }

        $rowCount = $import->getRowCount();
        $countErrors = count($errors);
        $unprocessedRecords = $import->getUnprocessedRecords();
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
        $unprocessed_details = [];
        if ($numberOfUnprocessedRecords > 0) {
            $unprocessed_message = "Hay $numberOfUnprocessedRecords que no tienen errores pero no fueron procesados porque ya existen.";
            foreach ($unprocessedRecords as $record) {
                $line = $record['line'];
                $code = $record['code'];
                $quality = $record['quality'];
                $weight = $record['weight'];
                $unprocessed_details[] = "Linea: $line, Codigo: $code, Calidad: $quality, Peso: $weight";
            }
        }

        return redirect()
            ->route('harvests.create.bulk')
            ->with('message_success', $message_success)
            ->with('unprocessed_message', $unprocessed_message)
            ->with('unprocessed_details', $unprocessed_details)
            ->with('error_message', $error_message)
            ->with('errors', $errors);
    }
}

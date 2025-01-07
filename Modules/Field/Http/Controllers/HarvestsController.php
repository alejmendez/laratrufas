<?php

namespace Modules\Field\Http\Controllers;

use Modules\Core\Http\Controllers\Controller;
use Modules\Field\Exports\HarvestsTemplateExport;
use Modules\Field\Http\Requests\BulkHarvestRequest;
use Modules\Field\Http\Requests\StoreHarvestRequest;
use Modules\Field\Http\Requests\UpdateHarvestRequest;
use Modules\Field\Http\Resources\HarvestResource;
use Modules\Field\Imports\HarvestsImport;
use Modules\Core\Services\Entities\ListEntity;
use Modules\Field\Services\HarvestDetails\ListHarvestQualities;
use Modules\Field\Services\Harvests\CreateHarvest;
use Modules\Field\Services\Harvests\DeleteHarvest;
use Modules\Field\Services\Harvests\FindHarvest;
use Modules\Field\Services\Harvests\ListHarvest;
use Modules\Field\Services\Harvests\UpdateHarvest;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

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

            return response()->json($harvests);
        }

        return Inertia::render('Harvests::List', [
            'toast' => session('toast'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Harvests::Create', [
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

        return Inertia::render('Harvests::Show', [
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

        return Inertia::render('Harvests::Edit', [
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
        return Excel::download(new HarvestsTemplateExport, 'carga_masiva_cosecha.xlsx');
    }

    public function create_bulk()
    {
        return Inertia::render('Harvests::Bulk/Create', [
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

        $message_success = '';
        if ($countErrors > 0) {
            $message_success = "Se han ingresado $rowCount registros al sistema y se tienen $countErrors errores.";
        } else {
            $message_success = "La carga de datos ha sido completada con éxito. Se han ingresado $rowCount registros de tipo de datos al sistema. ¡Buen trabajo!";
        }

        $error_message = '';
        if ($countErrors > 0) {
            $error_message = "Hay $countErrors errores o advertencias que debes corregir. Puedes ver el detalle de los errores en el resumen de la carga.";
        }

        $unprocessed_message = '';
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

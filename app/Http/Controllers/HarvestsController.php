<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

use App\Services\Harvests\FindHarvest;
use App\Services\Harvests\ListHarvest;
use App\Services\Harvests\HarvestAvailableYears;
use App\Services\Harvests\CreateHarvest;
use App\Services\Harvests\UpdateHarvest;
use App\Services\Harvests\DeleteHarvest;
use App\Services\HarvestDetails\ListHarvestQualities;

use App\Services\Quarters\ListQuarter;
use App\Services\Dogs\ListDog;
use App\Services\Entities\ListEntity;

use App\Http\Resources\HarvestResource;
use App\Http\Resources\HarvestCollection;
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
        $order = request('order', '');
        $search = request('search', '');
        $filter_year = request('filter_year', '');
        $filter_field = request('filter_field', '');
        $filter_quarter = request('filter_quarter', '');

        $filter_field_options = ListEntity::call('field');
        $filter_quarter_options = ListEntity::call('quarter', $filter_field === '' ? [] : ['field_id' => $filter_field]);

        $harvests = ListHarvest::call($order, $search, [
            'year' => $filter_year,
            'field_id' => $filter_field,
            'quarter_id' => $filter_quarter,
        ]);

        return Inertia::render('Harvests/List', [
            'order' => $order,
            'search' => $search,
            'filter_year' => $filter_year,
            'filter_year_options' => HarvestAvailableYears::call(),
            'filter_field' => $filter_field,
            'filter_field_options' => $filter_field_options,
            'filter_quarter' => $filter_quarter,
            'filter_quarter_options' => $filter_quarter_options,
            'toast' => session('toast'),
            'data' => $harvests->paginate()->withQueryString(),
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
        return redirect()->route('harvests.index');
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
            'alert' => session('alert'),
            'errors' => session('errors', []),
        ]);
    }

    public function store_bulk(BulkHarvestRequest $request)
    {
        try {
            $file = request()->file('bulk_file');
            $harvest_id = $request['harvest_id']['value'];

            $harvests_import = new HarvestsImport($harvest_id);
            $harvests_import->import($file);

            $errors = [];
            foreach ($harvests_import->failures() as $failure) {
                foreach ($failure->errors() as $error) {
                    $errors[] = "Linea {$failure->row()}: {$error}";
                }
           }

           $rowCount = $harvests_import->getRowCount();
           $message_success = "La carga de datos ha sido completada con éxito. Se han ingresado $rowCount registros de tipo de datos al sistema. ¡Buen trabajo!";

           $countErrors = count($errors);
           if ($countErrors > 0) {
               $message_success = "Se han ingresado $rowCount registros al sistema y se tienen $countErrors errores.";
           }

            return redirect()
                ->route('harvests.create.bulk')
                ->with('alert', $message_success)
                ->with('errors', $errors);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            $errors = [];
            foreach ($failures as $failure) {
                foreach ($failure->errors() as $error) {
                    $errors[] = "Linea {$failure->row()}: {$error}";
                }
            }
            return redirect()->route('harvests.create.bulk')->with('errors', $errors);
        } catch (Exception $e) {
            return redirect()->route('harvests.create.bulk')->with('errors', []);
        }
    }
}

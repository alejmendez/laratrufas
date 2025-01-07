<?php

use App\Http\Controllers\BatchesController;
use App\Http\Controllers\BulksController;
use App\Http\Controllers\DogsController;
use App\Http\Controllers\FieldsController;
use App\Http\Controllers\HarvestDetailsController;
use App\Http\Controllers\PlantDetailsController;
use App\Http\Controllers\HarvestsController;
use App\Http\Controllers\LiquidationsController;
use App\Http\Controllers\MachineriesController;
use App\Http\Controllers\PlantsController;
use App\Http\Controllers\PlantTypesController;
use App\Http\Controllers\QuartersController;
use App\Http\Controllers\ToolsController;
use App\Http\Controllers\SecurityEquipmentsController;
use App\Http\Controllers\ImportersController;
use App\Http\Controllers\GraphsController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/bulk', [BulksController::class, 'index'])->name('bulk.index');

    Route::get('/plants/bulk', [PlantsController::class, 'create_bulk'])->name('plants.create.bulk');
    Route::post('/plants/bulk', [PlantsController::class, 'store_bulk'])->name('plants.store.bulk');
    Route::get('/plants/download/bulk/template', [PlantsController::class, 'download_bulk_template'])->name('plants.download.bulk.template');

    Route::get('/harvests/bulk/{id?}', [HarvestsController::class, 'create_bulk'])->name('harvests.create.bulk');
    Route::post('/harvests/bulk', [HarvestsController::class, 'store_bulk'])->name('harvests.store.bulk');
    Route::get('/harvests/download/bulk/template', [HarvestsController::class, 'download_bulk_template'])->name('harvests.download.bulk.template');

    Route::get('/harvests/details', [HarvestDetailsController::class, 'create'])->name('harvests.details.create');
    Route::post('/harvests/details', [HarvestDetailsController::class, 'store'])->name('harvests.details.store');
    Route::get('/harvests/details/{code}', [HarvestDetailsController::class, 'find_by_code'])->name('harvests.details.find_by_code');
    Route::post('/plants/details', [PlantDetailsController::class, 'store'])->name('plant.details.store');
    Route::get('/plants/details/{id}', [PlantDetailsController::class, 'index'])->name('plants.details');
    Route::get('/plants/details/quarter/{id}', [PlantDetailsController::class, 'index_by_quarter'])->name('plants.details.by_quarter');
    Route::get('/plants/details/field/{id}', [PlantDetailsController::class, 'index_by_field'])->name('plants.details.by_field');

    Route::post('/plants/types', [PlantTypesController::class, 'store'])->name('plants.types.store');
    Route::post('/importers', [ImportersController::class, 'store'])->name('importers.store');

    Route::get('/quarter/{id}/plants', [QuartersController::class, 'plants'])->name('quarters.plants');
    Route::put('/quarter/{id}/plants/position', [QuartersController::class, 'plants_update_position'])->name('quarters.plants.update.position');
    Route::get('/graphs/{id}/{type}', [GraphsController::class, 'index'])->name('graphs');

    Route::resources([
        'fields' => FieldsController::class,
        'quarters' => QuartersController::class,
        'plants' => PlantsController::class,
        'dogs' => DogsController::class,
        'harvests' => HarvestsController::class,
        'tools' => ToolsController::class,
        'machineries' => MachineriesController::class,
        'batches' => BatchesController::class,
        'liquidations' => LiquidationsController::class,
        'security_equipments' => SecurityEquipmentsController::class,
    ]);
});

require __DIR__.'/../Modules/Core/Routes/web.php';

require __DIR__.'/../Modules/Auth/Routes/web.php';
require __DIR__.'/../Modules/Dashboard/Routes/web.php';
require __DIR__.'/../Modules/Users/Routes/web.php';
require __DIR__.'/../Modules/Tasks/Routes/web.php';

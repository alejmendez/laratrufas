<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\FieldsController;
use App\Http\Controllers\QuartersController;
use App\Http\Controllers\PlantsController;
use App\Http\Controllers\PlantTypesController;
use App\Http\Controllers\DogsController;
use App\Http\Controllers\HarvestsController;
use App\Http\Controllers\HarvestDetailsController;
use App\Http\Controllers\BulksController;
use App\Http\Controllers\ToolsController;
use App\Http\Controllers\EquipmentsController;

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['verified'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

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

    Route::post('/plants/types', [PlantTypesController::class, 'store'])->name('plants.types.store');

    Route::resources([
        'users' => UsersController::class,
        'fields' => FieldsController::class,
        'quarters' => QuartersController::class,
        'plants' => PlantsController::class,
        'dogs' => DogsController::class,
        'harvests' => HarvestsController::class,
        'tools' => ToolsController::class,
        'equipments' => EquipmentsController::class,
    ]);
});

require __DIR__.'/auth.php';

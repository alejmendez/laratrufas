<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use App\Services\Entities\ListEntity;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Dashboard/Index', [
            'fields' => ListEntity::call('field'),
        ]);
    }
}

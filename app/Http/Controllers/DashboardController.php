<?php

namespace App\Http\Controllers;

use App\Services\Entities\ListEntity;
use Inertia\Inertia;

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

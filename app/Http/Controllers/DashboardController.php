<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\ShowDashboard;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $field_id = request('field_id');
        return Inertia::render('Dashboard/Index', ShowDashboard::call($field_id));
    }
}

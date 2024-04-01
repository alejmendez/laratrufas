<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class BulksController extends Controller
{
    public function index()
    {
        return Inertia::render('Bulk/List');
    }
}

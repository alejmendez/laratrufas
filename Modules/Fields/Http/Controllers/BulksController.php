<?php

namespace Modules\Fields\Http\Controllers;

use Modules\Core\Http\Controllers\Controller;
use Inertia\Inertia;

class BulksController extends Controller
{
    public function index()
    {
        return Inertia::render('Fields::Bulk/List');
    }
}
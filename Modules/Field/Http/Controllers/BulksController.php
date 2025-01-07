<?php

namespace Modules\Field\Http\Controllers;

use Modules\Core\Http\Controllers\Controller;
use Inertia\Inertia;

class BulksController extends Controller
{
    public function index()
    {
        return Inertia::render('Bulk::List');
    }
}

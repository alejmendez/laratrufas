<?php

namespace Modules\Fields\Http\Controllers;

use Inertia\Inertia;
use Modules\Core\Http\Controllers\Controller;
use Modules\Core\Traits\HasPermissionMiddleware;

class BulksController extends Controller
{
    use HasPermissionMiddleware;

    public function index()
    {
        return Inertia::render('Fields::Bulk/List');
    }
}

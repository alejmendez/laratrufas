<?php

namespace Modules\Fields\Http\Controllers;

use Modules\Core\Http\Controllers\Controller;
use Modules\Core\Traits\HasPermissionMiddleware;
use Inertia\Inertia;

class BulksController extends Controller
{
    use HasPermissionMiddleware;
    public function index()
    {
        return Inertia::render('Fields::Bulk/List');
    }
}

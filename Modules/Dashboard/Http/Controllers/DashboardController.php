<?php

namespace Modules\Dashboard\Http\Controllers;

use Inertia\Inertia;
use Modules\Core\Http\Controllers\Controller;
use Modules\Dashboard\Services\ShowDashboard;
use Modules\Fields\Http\Resources\FieldResource;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $field_id = request('field_id');
        $data = ShowDashboard::call($field_id);
        $data['field'] = new FieldResource($data['field']);

        return Inertia::render('Dashboard::Index', $data);
    }
}

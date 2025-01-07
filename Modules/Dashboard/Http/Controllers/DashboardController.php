<?php

namespace Modules\Dashboard\Http\Controllers;

use Inertia\Inertia;

use Modules\Core\Http\Controllers\Controller;
use App\Http\Resources\FieldResource;
use Modules\Dashboard\Services\ShowDashboard;

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

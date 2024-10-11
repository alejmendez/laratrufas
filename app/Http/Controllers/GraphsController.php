<?php

namespace App\Http\Controllers;

use App\Services\Graphs\GraphData;

class GraphsController extends Controller
{
    public function index()
    {
        $id = request('id');
        $type = request('type', '');
        $filters = request('filters', '');

        return GraphData::call($id, $type, $filters);
    }
}

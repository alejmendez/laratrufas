<?php

namespace App\Http\Controllers;

use Modules\Core\Http\Controllers\Controller;
use App\Services\Graphs\GraphData;

class GraphsController extends Controller
{
    public function index()
    {
        $id = request('id');
        $year = request('year', date('Y'));
        $type = request('type', '');
        $filters = request('filters', '');

        return GraphData::call($id, $year, $type, $filters);
    }
}

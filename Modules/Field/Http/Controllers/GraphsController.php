<?php

namespace Modules\Field\Http\Controllers;

use Modules\Core\Http\Controllers\Controller;
use Modules\Field\Services\Graphs\GraphData;

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

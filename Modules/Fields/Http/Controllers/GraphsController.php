<?php

namespace Modules\Fields\Http\Controllers;

use Modules\Core\Http\Controllers\Controller;
use Modules\Fields\Services\Graphs\GraphData;
use Modules\Core\Traits\HasPermissionMiddleware;
class GraphsController extends Controller
{
    use HasPermissionMiddleware;
    public function index()
    {
        $id = request('id');
        $year = request('year');
        $type = request('type', '');
        $filters = request('filters', '');

        return GraphData::call($id, $year, $type, $filters);
    }
}

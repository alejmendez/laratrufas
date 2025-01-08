<?php

namespace Modules\Fields\Http\Controllers;

use Modules\Core\Http\Controllers\Controller;
use Modules\Fields\Services\Graphs\GraphData;
use Modules\Fields\Models\Field;
use Modules\Fields\Services\Harvests\HarvestAvailableLastYear;

class GraphsController extends Controller
{
    public function index()
    {
        $id = request('id');
        $field = Field::findOrFail($id);
        $harvest_available_last_year = HarvestAvailableLastYear::call($field);
        $year = request('year', $harvest_available_last_year);
        $type = request('type', '');
        $filters = request('filters', '');

        return GraphData::call($id, $year, $type, $filters);
    }
}

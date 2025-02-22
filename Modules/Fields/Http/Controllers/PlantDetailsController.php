<?php

namespace Modules\Fields\Http\Controllers;

use Modules\Core\Http\Controllers\Controller;
use Modules\Core\Traits\HasPermissionMiddleware;
use Modules\Fields\Http\Requests\StorePlantDetailRequest;
use Modules\Fields\Http\Resources\PlantDetailCollection;
use Modules\Fields\Services\PlantDetails\CreatePlantDetails;
use Modules\Fields\Services\PlantDetails\FindPlantDetails;

class PlantDetailsController extends Controller
{
    use HasPermissionMiddleware;

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePlantDetailRequest $request)
    {
        CreatePlantDetails::call($request->validated());

        return redirect()->route('harvests.details.create');
    }

    public function index(int $id)
    {
        $show_harvests = request('show_harvests') === 'true';
        $plant_details = FindPlantDetails::get_by_plant_id($id, $show_harvests);

        return new PlantDetailCollection($plant_details);
    }

    public function index_by_quarter(int $id)
    {
        $show_harvests = request('show_harvests') === 'true';
        $plant_details = FindPlantDetails::get_by_quarter_id($id, $show_harvests);

        return new PlantDetailCollection($plant_details);
    }

    public function index_by_field(int $id)
    {
        $show_harvests = request('show_harvests') === 'true';
        $plant_details = FindPlantDetails::get_by_field_id($id, $show_harvests);

        return new PlantDetailCollection($plant_details);
    }
}

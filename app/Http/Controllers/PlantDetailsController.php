<?php

namespace App\Http\Controllers;

use Modules\Core\Http\Controllers\Controller;
use App\Http\Requests\StorePlantDetailRequest;
use App\Http\Resources\PlantDetailCollection;

use App\Services\PlantDetails\CreatePlantDetails;
use App\Services\PlantDetails\FindPlantDetails;

class PlantDetailsController extends Controller
{
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

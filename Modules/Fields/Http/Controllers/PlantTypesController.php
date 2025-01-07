<?php

namespace Modules\Fields\Http\Controllers;

use Modules\Core\Http\Controllers\Controller;
use Modules\Fields\Services\PlantTypes\CreatePlantType;

class PlantTypesController extends Controller
{
    public function store()
    {
        $name = request('name', '');
        $type = CreatePlantType::call($name);

        return [
            'type' => $type,
        ];
    }
}

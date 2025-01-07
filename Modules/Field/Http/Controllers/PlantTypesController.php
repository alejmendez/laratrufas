<?php

namespace Modules\Field\Http\Controllers;

use Modules\Core\Http\Controllers\Controller;
use Modules\Field\Services\PlantTypes\CreatePlantType;

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

<?php

namespace App\Http\Controllers;

use App\Services\Entities\ListEntities;
use App\Services\Entities\ListEntity;

class SelectsController extends Controller
{
    public function index()
    {
        $entity = request('entity');
        $filter = request('filter', []);

        if ($entity === 'multiple') {
            $entities = json_decode(request('entities', '{}'));

            return response()->json(ListEntities::call($entities));
        }

        return response()->json(ListEntity::call($entity, $filter));
    }
}

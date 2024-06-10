<?php

namespace App\Http\Controllers;

use App\Services\Entities\ListEntity;

class SelectsController extends Controller
{
    public function index()
    {
        $entity = request('entity');
        $filter = request('filter', []);

        $data = ListEntity::call($entity, $filter);

        return response()->json($data);
    }
}

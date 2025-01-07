<?php

namespace Modules\Core\Http\Controllers;

use Modules\Core\Services\ListEntities;
use Modules\Core\Services\ListEntity;

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

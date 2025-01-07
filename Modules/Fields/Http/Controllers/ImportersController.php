<?php

namespace Modules\Fields\Http\Controllers;

use Modules\Core\Http\Controllers\Controller;
use Modules\Fields\Services\Importers\CreateImporter;

class ImportersController extends Controller
{
    public function store()
    {
        $name = request('name', '');
        $importer = CreateImporter::call($name);

        return [
            'importer' => $importer,
        ];
    }
}

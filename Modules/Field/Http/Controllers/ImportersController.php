<?php

namespace Modules\Field\Http\Controllers;

use Modules\Core\Http\Controllers\Controller;
use Modules\Field\Services\Importers\CreateImporter;

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

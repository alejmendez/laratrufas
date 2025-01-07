<?php

namespace App\Http\Controllers;

use Modules\Core\Http\Controllers\Controller;
use App\Services\Importers\CreateImporter;

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

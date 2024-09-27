<?php

namespace App\Services\Importers;

use App\Models\Importer;
use Illuminate\Support\Str;

class CreateImporter
{
    public static function call($name): Importer
    {
        $slug = Str::slug($name);
        $importer = Importer::where('slug', $slug)->first();
        if (!$importer) {
            $importer = new Importer;
        }

        $importer->name = $name;
        $importer->slug = $slug;
        $importer->save();

        return $importer;
    }
}

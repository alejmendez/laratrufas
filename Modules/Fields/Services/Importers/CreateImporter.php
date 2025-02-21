<?php

namespace Modules\Fields\Services\Importers;

use Modules\Fields\Models\Importer;
use Illuminate\Support\Str;

class CreateImporter
{
    public static function call($data): Importer
    {
        $slug = Str::slug($data['name']);
        $importer = Importer::where('slug', $slug)->first();
        if (!$importer) {
            $importer = new Importer;
            $importer->name = $data['name'];
            $importer->slug = $slug;
            $importer->save();
        }

        return $importer;
    }
}

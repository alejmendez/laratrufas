<?php

namespace Modules\Fields\Services\Importers;

use Modules\Fields\Models\Importer;
use Illuminate\Support\Str;

class UpdateImporter
{
    public static function call($id, $data): Importer
    {
        $slug = Str::slug($data['name']);

        $type = Importer::findOrFail($id);
        $type->name = $data['name'];
        $type->slug = $slug;
        $type->save();

        return $type;
    }
}

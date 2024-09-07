<?php

namespace App\Services\Fields;

use App\Models\Field;
use App\Services\Owners\CreateOrUpdateOwner;

class UpdateField
{
    public static function call($id, $data): Field
    {
        $field = Field::findOrFail($id);

        $field->name = $data['name'];
        $field->location = $data['location'];
        $field->size = $data['size'];

        if (isset($data['owner_dni'])) {
            $owner = CreateOrUpdateOwner::call($data['owner_dni'], $data['owner_name']);
            $field->owner_id = $owner->id;
        }

        if ($data['blueprint']) {
            $field->blueprint = $data['blueprint'];
        }

        if ($data['blueprintRemove'] === '1') {
            $field->blueprint = null;
        }

        $field->save();

        return $field;
    }
}

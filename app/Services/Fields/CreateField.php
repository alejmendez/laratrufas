<?php

namespace App\Services\Fields;

use App\Services\Owners\CreateOrUpdateOwner;
use App\Models\Field;

class CreateField
{
    public static function call($data): Field
    {
        $field = new Field;

        $field->name = $data['name'];
        $field->location = $data['location'];
        $field->size = $data['size'];
        $field->blueprint = $data['blueprint'];

        if (isset($data['owner_dni'])) {
            $owner = CreateOrUpdateOwner::call($data['owner_dni'], $data['owner_name']);
            $field->owner_id = $owner->id;
        }

        $field->save();

        return $field;
    }
}

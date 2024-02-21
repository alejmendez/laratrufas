<?php

namespace App\Services\Fields;

use App\Services\Owners\CreateOrUpdateOwner;
use App\Models\Field;

class UpdateField
{
    public static function call($id, $data): Field
    {
        unset($data['id']);
        $field = Field::findOrFail($id);

        if (!$data['blueprint']) {
            unset($data['blueprint']);
        }

        if ($data['blueprintRemove'] === '1') {
            $data['blueprint'] = null;
        }

        if (isset($data['owner_dni'])) {
            $owner = CreateOrUpdateOwner::call($data['owner_dni'], $data['owner_name']);
            unset($data['owner_dni']);
            unset($data['owner_name']);
            $data['owner_id'] = $owner->id;
        }

        $field->update($data);

        return $field;
    }
}

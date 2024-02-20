<?php

namespace App\Services\Fields;

use App\Services\Owners\CreateOrUpdateOwner;
use App\Models\Field;

class CreateField
{
    public static function call($data): Field
    {
        if (isset($data['owner_dni'])) {
            $owner = CreateOrUpdateOwner::call($data['owner_dni'], $data['owner_name']);
            unset($data['owner_dni']);
            unset($data['owner_name']);
            $data['owner_id'] = $owner->id;
        }
        $field = Field::create($data);
        return $field;
    }
}

<?php

namespace App\Services\Quarters;

use App\Models\Quarter;

class UpdateQuarter
{
    public static function call($id, $data): Quarter
    {
        unset($data['id']);
        $quarter = Quarter::findOrFail($id);

        if (!$data['blueprint']) {
            unset($data['blueprint']);
        }

        if ($data['blueprintRemove'] === '1') {
            $data['blueprint'] = null;
        }

        $quarter->update($data);

        return $quarter;
    }
}

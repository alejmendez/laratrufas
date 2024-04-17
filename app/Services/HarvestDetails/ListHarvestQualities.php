<?php

namespace App\Services\HarvestDetails;

use App\Models\HarvestDetails;

use Illuminate\Support\Str;

class ListHarvestQualities
{
    const QUALITIES = [
        'Extra',
        'First',
        'Big',
        'Second',
        'Small',
        'Extra small',
        'Mini',
        'Pieces',
        'Industrial',
    ];

    public static function call($format): Array
    {
        if ($format === 'values') {
            return array_map(fn($quality) => Str::slug($quality), self::QUALITIES);
        }

        if ($format === 'select') {
            return array_map(fn($quality) => [ 'value' => Str::slug($quality), 'text' => $quality ], self::QUALITIES);
        }

        return [];
    }
}

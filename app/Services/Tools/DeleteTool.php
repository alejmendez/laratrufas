<?php

namespace App\Services\Tools;

use App\Models\Tool;

class DeleteTool
{
    public static function call($id): void
    {
        Tool::destroy($id);
    }
}

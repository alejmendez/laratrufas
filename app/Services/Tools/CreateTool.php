<?php

namespace App\Services\Tools;

use App\Models\Tool;

class CreateTool
{
    public static function call($data): Tool
    {
        $tool = Tool::create($data);
        return $tool;
    }
}

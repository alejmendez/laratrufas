<?php

namespace App\Services\Tools;

use App\Models\Tool;

class FindTool
{
    public static function call($id)
    {
        $tool = Tool::findOrFail($id);

        return $tool;
    }
}

<?php

namespace App\Services\Tools;

use App\Models\Tool;
use App\Models\ToolVaccine;

class UpdateTool
{
    public static function call($id, $data): Tool
    {
        $tool = Tool::findOrFail($id);
        $tool->update($data);

        return $tool;
    }
}

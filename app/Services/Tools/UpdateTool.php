<?php

namespace App\Services\Tools;

use App\Models\Tool;
use App\Models\ToolVaccine;

class UpdateTool
{
    public static function call($id, $data): Tool
    {
        $tool = Tool::findOrFail($id);

        $tool->name = $data['name'];
        $tool->purchase_date = $data['purchase_date'];
        $tool->last_maintenance = $data['last_maintenance'];
        $tool->purchase_location = $data['purchase_location'];
        $tool->type = $data['type'];
        $tool->contact = $data['contact'];
        $tool->note = $data['note'];
        $tool->save();

        return $tool;
    }
}

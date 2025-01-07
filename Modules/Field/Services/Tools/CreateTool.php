<?php

namespace Modules\Field\Services\Tools;

use Modules\Field\Models\Tool;

class CreateTool
{
    public static function call($data): Tool
    {
        $tool = new Tool;

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

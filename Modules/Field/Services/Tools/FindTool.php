<?php

namespace Modules\Field\Services\Tools;

use Modules\Field\Models\Tool;

class FindTool
{
    public static function call($id)
    {
        $tool = Tool::findOrFail($id);

        return $tool;
    }
}

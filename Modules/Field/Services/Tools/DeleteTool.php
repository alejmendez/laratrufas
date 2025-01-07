<?php

namespace Modules\Field\Services\Tools;

use Modules\Field\Models\Tool;

class DeleteTool
{
    public static function call($id): void
    {
        Tool::destroy($id);
    }
}

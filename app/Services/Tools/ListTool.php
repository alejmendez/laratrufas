<?php

namespace App\Services\Tools;

use App\Models\Tool;

class ListTool
{
    public static function call($order = '', $search = '')
    {
        $tools = Tool::order($order)->search($search);

        return $tools;
    }
}

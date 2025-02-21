<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Modules\Core\Traits\HasPermissionMiddleware;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, HasPermissionMiddleware;
}

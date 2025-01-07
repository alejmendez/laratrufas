<?php

namespace Modules\Users\Services;

use Modules\Users\Models\User;
use Modules\Core\Services\CacheService;

class DeleteUser
{
    public static function call($id): void
    {
        CacheService::clearUserCacheById($id);
        User::destroy($id);
    }
}

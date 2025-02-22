<?php

namespace Modules\Users\Services;

use Modules\Core\Services\CacheService;
use Modules\Users\Models\User;

class DeleteUser
{
    public static function call($id): void
    {
        CacheService::clearUserCacheById($id);
        User::destroy($id);
    }
}

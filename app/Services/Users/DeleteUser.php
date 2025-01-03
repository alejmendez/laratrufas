<?php

namespace App\Services\Users;

use App\Models\User;
use App\Services\Caches\CacheService;

class DeleteUser
{
    public static function call($id): void
    {
        CacheService::clearUserCacheById($id);
        User::destroy($id);
    }
}

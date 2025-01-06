<?php

namespace App\Services\Caches;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Modules\Users\Models\User;

class CacheService
{
    protected static int $userDataTtl = 600;
    protected static int $unreadNotificationsTtl = 60;

    public static function getUserAvatar(User $user)
    {
        return cache()->remember('user_' . $user->id . '_avatar', self::$userDataTtl, function () use ($user) {
            return $user->avatar_url;
        });
    }

    public static function getUserRoles(User $user)
    {
        return cache()->remember('user_' . $user->id . '_roles', self::$userDataTtl, function () use ($user) {
            return collect($user->getRoleNames())->map(fn ($roleName) => Str::slug($roleName));
        });
    }

    public static function getUserPermissions(User $user)
    {
        return cache()->remember('user_' . $user->id . '_permissions', self::$userDataTtl, function () use ($user) {
            return $user->getAllPermissions()->pluck('name')->map(fn ($permissionName) => Str::slug($permissionName));
        });
    }

    public static function getUserUnreadNotifications(User $user)
    {
        return cache()->remember('user_' . $user->id . '_unreadnotifications', self::$unreadNotificationsTtl, function () use ($user) {
            return $user->unreadNotifications->where('type', '!=', 'Modules\Tasks\Notifications\TaskNotification');
        });
    }

    public static function clearUserCache(User $user)
    {
        self::clearUserCacheById($user->id);
    }

    public static function clearUserCacheById($userId)
    {
        cache()->forget('user_' . $userId);
        cache()->forget('user_' . $userId . '_avatar');
        cache()->forget('user_' . $userId . '_roles');
        cache()->forget('user_' . $userId . '_permissions');
        cache()->forget('user_' . $userId . '_unreadnotifications');
    }
}

<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Services\Notifications\ListNotification;

class NotificationsController extends Controller
{
    public function unread()
    {
        $user = auth()->user();
        $type = request()->route('type');
        return ListNotification::call($user, $type);
    }
}

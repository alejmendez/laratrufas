<?php

use Illuminate\Support\Facades\Route;
use Modules\Core\Http\Controllers\NotificationsController;
use Modules\Core\Http\Controllers\SelectsController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/select/{entity}', [SelectsController::class, 'index'])->name('selects.index');
    Route::get('/select/multiple', [SelectsController::class, 'multiple'])->name('selects.multiple');

    Route::get('/notifications/{type}/unread', [NotificationsController::class, 'unread'])->name('notifications.unread');
});

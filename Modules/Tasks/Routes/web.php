<?php

use Modules\Tasks\Http\Controllers\TasksController;
use Modules\Tasks\Http\Controllers\TaskCommentsController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::post('/task/comments', [TaskCommentsController::class, 'store'])->name('task.comments.store');
    Route::put('/task/comments/{taskComment}', [TaskCommentsController::class, 'update'])->name('task.comments.update');
    Route::delete('/task/comments/{taskComment}', [TaskCommentsController::class, 'destroy'])->name('task.comments.destroy');

    Route::resources([
        'tasks' => TasksController::class,
    ]);
});

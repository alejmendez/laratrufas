<?php

use Modules\Tasks\Http\Controllers\TasksController;
use Modules\Tasks\Http\Controllers\TaskCommentsController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::post('/task/comments', [TaskCommentsController::class, 'store'])->name('task.comments.store');
    Route::put('/task/comments/{taskComment}', [TaskCommentsController::class, 'update'])->name('task.comments.update');
    Route::delete('/task/comments/{taskComment}', [TaskCommentsController::class, 'destroy'])->name('task.comments.destroy');

    Route::get('/tasks', [TasksController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [TasksController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [TasksController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}', [TasksController::class, 'show'])->name('tasks.show');
    Route::get('/tasks/{task}/edit', [TasksController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}', [TasksController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TasksController::class, 'destroy'])->name('tasks.destroy');
});

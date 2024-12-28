<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskCommentRequest;
use App\Http\Requests\UpdateTaskCommentRequest;
use App\Services\TaskComment\NotifyTaskComment;
use Inertia\Inertia;

class TaskCommentsController extends Controller
{
    public function store(StoreTaskCommentRequest $request)
    {
        $data = $request->validated();
        $taskComment = CreateTaskComment::call($data, auth()->user());
        NotifyTaskComment::call($taskComment->task, $data['comment'], auth()->user());

        return [
            'status' => 'success',
            'message' => 'Task comment created.',
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskCommentRequest $request, string $id)
    {
        $data = $request->validated();
        $taskComment = UpdateTaskComment::call($id, $data);
        NotifyTaskComment::call($taskComment->task, $data['comment'], auth()->user());

        return [
            'status' => 'success',
            'message' => 'Task comment updated.',
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DeleteTaskComment::call($id);

        return response()->noContent();
    }
}

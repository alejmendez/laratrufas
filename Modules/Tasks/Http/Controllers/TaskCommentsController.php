<?php

namespace Modules\Tasks\Http\Controllers;

use Modules\Core\Http\Controllers\Controller;
use Modules\Core\Traits\HasPermissionMiddleware;
use Modules\Tasks\Http\Requests\StoreTaskCommentRequest;
use Modules\Tasks\Http\Requests\UpdateTaskCommentRequest;
use Modules\Tasks\Http\Resources\TaskCommentResource;
use Modules\Tasks\Services\CreateTaskComment;
use Modules\Tasks\Services\DeleteTaskComment;
use Modules\Tasks\Services\NotifyTaskComment;
use Modules\Tasks\Services\UpdateTaskComment;

class TaskCommentsController extends Controller
{
    use HasPermissionMiddleware;

    public function store(StoreTaskCommentRequest $request)
    {
        $data = $request->validated();
        $taskComment = CreateTaskComment::call($data, auth()->user());
        NotifyTaskComment::call($taskComment->task, $data['comment'], auth()->user());

        return response()->json([
            'data' => new TaskCommentResource($taskComment),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskCommentRequest $request, string $id)
    {
        $data = $request->validated();
        $taskComment = UpdateTaskComment::call($id, $data);
        NotifyTaskComment::call($taskComment->task, $data['comment'], auth()->user());

        return response()->json([
            'data' => new TaskCommentResource($taskComment),
        ]);
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

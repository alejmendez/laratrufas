<?php

namespace Modules\Tasks\Http\Controllers;

use Modules\Core\Http\Controllers\Controller;
use Modules\Core\Services\ListEntity;
use Modules\Tasks\Http\Requests\StoreTaskRequest;
use Modules\Tasks\Http\Requests\UpdateTaskRequest;
use Modules\Tasks\Http\Resources\TaskResource;
use Modules\Tasks\Services\CreateTask;
use Modules\Tasks\Services\DeleteTask;
use Modules\Tasks\Services\FindTask;
use Modules\Tasks\Services\ListTask;
use Modules\Tasks\Services\UpdateTask;
use Modules\Tasks\Services\NotifyTaskComment;
use Modules\Tasks\Services\MarkTaskNotificationAsRead;
use Inertia\Inertia;
use Modules\Core\Traits\HasPermissionMiddleware;

class TasksController extends Controller
{
    use HasPermissionMiddleware;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->exists('dt_params')) {
            $params = json_decode(request('dt_params', '[]'), true);

            return response()->json(ListTask::call($params));
        }

        return Inertia::render('Tasks::List', [
            'toast' => session('toast'),
            'status' => request('status'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Tasks::Create', [
            'fields' => ListEntity::call('field'),
            'responsibles' => ListEntity::call('responsible'),
            'tools' => ListEntity::call('tool'),
            'security_equipments' => ListEntity::call('security_equipment'),
            'machineries' => ListEntity::call('machinery'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $data = $request->validated();
        $task = CreateTask::call($data);
        NotifyTaskComment::call($task, $data['comment'], auth()->user());

        return redirect()->route('tasks.index')->with('toast', 'Task created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = FindTask::call($id);
        $current_user = auth()->user();
        MarkTaskNotificationAsRead::call($task, $current_user);

        return Inertia::render('Tasks::Show', [
            'data' => new TaskResource($task),
            'fields' => ListEntity::call('field'),
            'quarters' => ListEntity::call('quarter', ['field_id' => $task->field_id]),
            'plants' => ListEntity::call('plant', ['quarter_id' => $task->quarters->map(fn ($q) => $q->id)->toArray()]),
            'responsibles' => ListEntity::call('responsible'),
            'tools' => ListEntity::call('tool'),
            'security_equipments' => ListEntity::call('security_equipment'),
            'machineries' => ListEntity::call('machinery'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $task = FindTask::call($id);

        return Inertia::render('Tasks::Edit', [
            'data' => new TaskResource($task),
            'fields' => ListEntity::call('field'),
            'quarters' => ListEntity::call('quarter', ['field_id' => $task->field_id]),
            'plants' => ListEntity::call('plant', ['quarter_id' => $task->quarters->map(fn ($q) => $q->id)->toArray()]),
            'responsibles' => ListEntity::call('responsible'),
            'tools' => ListEntity::call('tool'),
            'security_equipments' => ListEntity::call('security_equipment'),
            'machineries' => ListEntity::call('machinery'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, string $id)
    {
        UpdateTask::call($id, $request->validated());

        return redirect()->route('tasks.index')->with('toast', 'Task updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DeleteTask::call($id);

        return response()->noContent();
    }
}

<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use App\Services\Tasks\FindTask;
use App\Services\Tasks\ListTask;
use App\Services\Tasks\CreateTask;
use App\Services\Tasks\UpdateTask;
use App\Services\Tasks\DeleteTask;
use App\Services\Fields\ListField;
use App\Services\Users\ListUser;

use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskCollection;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order = request('order', '');
        $search = request('search', '');
        $tasks = ListTask::call($order, $search);

        return Inertia::render('Tasks/List', [
            'order' => $order,
            'search' => $search,
            'toast' => session('toast'),
            'data' => new TaskCollection($tasks->paginate()->withQueryString()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Tasks/Create', [
            'fields' => $this->getSelectFields(),
            'responsibles' => $this->getSelectResponsibles(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        CreateTask::call($request->validated());

        return redirect()->route('tasks.index')->with('toast', 'Task created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = FindTask::call($id);

        return Inertia::render('Tasks/Show', [
            'data' => new TaskResource($task),
            'fields' => $this->getSelectFields(),
            'responsibles' => $this->getSelectResponsibles(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $task = FindTask::call($id);

        return Inertia::render('Tasks/Edit', [
            'data' => new TaskResource($task),
            'fields' => $this->getSelectFields(),
            'responsibles' => $this->getSelectResponsibles(),
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
        return redirect()->back();
    }

    protected function getSelectFields()
    {
        return collect(ListField::call('name')->get())->map(fn($field) => [ 'value' => $field->id, 'text' => $field->name ]);
    }

    protected function getSelectResponsibles()
    {
        return collect(ListUser::call('name')->get())
            ->map(fn($responsible) => [ 'value' => $responsible->id, 'text' => $responsible->full_name ]);
    }
}

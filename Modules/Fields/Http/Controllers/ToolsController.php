<?php

namespace Modules\Fields\Http\Controllers;

use Modules\Core\Http\Controllers\Controller;
use Modules\Fields\Http\Requests\StoreToolRequest;
use Modules\Fields\Http\Requests\UpdateToolRequest;
use Modules\Fields\Http\Resources\ToolResource;
use Modules\Fields\Services\Tools\CreateTool;
use Modules\Fields\Services\Tools\DeleteTool;
use Modules\Fields\Services\Tools\FindTool;
use Modules\Fields\Services\Tools\ListTool;
use Modules\Fields\Services\Tools\UpdateTool;
use Inertia\Inertia;
use Modules\Core\Traits\HasPermissionMiddleware;
class ToolsController extends Controller
{
    use HasPermissionMiddleware;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->exists('dt_params')) {
            $params = json_decode(request('dt_params', '[]'), true);

            return response()->json(ListTool::call($params));
        }

        return Inertia::render('Fields::Tools/List', [
            'toast' => session('toast'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Fields::Tools/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreToolRequest $request)
    {
        CreateTool::call($request->validated());

        return redirect()->route('tools.index')->with('toast', 'Tool created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tool = FindTool::call($id);

        return Inertia::render('Fields::Tools/Show', [
            'data' => new ToolResource($tool),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tool = FindTool::call($id);

        return Inertia::render('Fields::Tools/Edit', [
            'data' => new ToolResource($tool),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateToolRequest $request, string $id)
    {
        UpdateTool::call($id, $request->validated());

        return redirect()->route('tools.index')->with('toast', 'Tool updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DeleteTool::call($id);

        return response()->noContent();
    }
}

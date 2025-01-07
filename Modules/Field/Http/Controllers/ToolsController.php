<?php

namespace Modules\Field\Http\Controllers;

use Modules\Core\Http\Controllers\Controller;
use Modules\Field\Http\Requests\StoreToolRequest;
use Modules\Field\Http\Requests\UpdateToolRequest;
use Modules\Field\Http\Resources\ToolResource;
use Modules\Field\Services\Tools\CreateTool;
use Modules\Field\Services\Tools\DeleteTool;
use Modules\Field\Services\Tools\FindTool;
use Modules\Field\Services\Tools\ListTool;
use Modules\Field\Services\Tools\UpdateTool;
use Inertia\Inertia;

class ToolsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->exists('dt_params')) {
            $params = json_decode(request('dt_params', '[]'), true);

            return response()->json(ListTool::call($params));
        }

        return Inertia::render('Tools::List', [
            'toast' => session('toast'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Tools::Create');
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

        return Inertia::render('Tools::Show', [
            'data' => new ToolResource($tool),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tool = FindTool::call($id);

        return Inertia::render('Tools::Edit', [
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

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreToolRequest;
use App\Http\Requests\UpdateToolRequest;
use App\Http\Resources\ToolResource;
use App\Services\Tools\CreateTool;
use App\Services\Tools\DeleteTool;
use App\Services\Tools\FindTool;
use App\Services\Tools\ListTool;
use App\Services\Tools\UpdateTool;
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

        return Inertia::render('Tools/List', [
            'toast' => session('toast'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Tools/Create');
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

        return Inertia::render('Tools/Show', [
            'data' => new ToolResource($tool),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tool = FindTool::call($id);

        return Inertia::render('Tools/Edit', [
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

<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use App\Services\Tools\FindTool;
use App\Services\Tools\ListTool;
use App\Services\Tools\CreateTool;
use App\Services\Tools\UpdateTool;
use App\Services\Tools\DeleteTool;

use App\Http\Resources\ToolResource;
use App\Http\Resources\ToolCollection;
use App\Http\Requests\StoreToolRequest;
use App\Http\Requests\UpdateToolRequest;

class ToolsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order = request('order', '');
        $search = request('search', '');
        $tools = ListTool::call($order, $search);

        return Inertia::render('Tools/List', [
            'order' => $order,
            'search' => $search,
            'toast' => session('toast'),
            'data' => $tools->paginate()->withQueryString(),
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
        return redirect()->route('tools.index');
    }
}

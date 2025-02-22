<?php

namespace Modules\Fields\Http\Controllers;

use Modules\Core\Http\Controllers\Controller;
use Modules\Fields\Http\Requests\StoreDogRequest;
use Modules\Fields\Http\Requests\UpdateDogRequest;
use Modules\Fields\Http\Resources\DogResource;
use Modules\Fields\Services\Dogs\CreateDog;
use Modules\Fields\Services\Dogs\DeleteDog;
use Modules\Fields\Services\Dogs\FindDog;
use Modules\Fields\Services\Dogs\ListDog;
use Modules\Fields\Services\Dogs\UpdateDog;
use Modules\Core\Services\ListEntity;
use Inertia\Inertia;
use Modules\Core\Traits\HasPermissionMiddleware;

class DogsController extends Controller
{
    use HasPermissionMiddleware;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->exists('dt_params')) {
            $params = json_decode(request('dt_params', '[]'), true);

            return response()->json(ListDog::call($params));
        }

        return Inertia::render('Fields::Dogs/List', [
            'toast' => session('toast'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Fields::Dogs/Create', [
            'fields' => ListEntity::call('field'),
            'couples' => ListEntity::call('couple'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDogRequest $request)
    {
        $data = $request->validated();
        $data['avatar'] = $this->storeAvatar($request);
        CreateDog::call($data);

        return redirect()->route('dogs.index')->with('toast', 'Dog created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dog = FindDog::call($id);

        return Inertia::render('Fields::Dogs/Show', [
            'data' => new DogResource($dog),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dog = FindDog::call($id);

        return Inertia::render('Fields::Dogs/Edit', [
            'data' => new DogResource($dog),
            'fields' => ListEntity::call('field'),
            'quarters' => ListEntity::call('quarter', ['field_id' => $dog->quarter->field_id]),
            'couples' => ListEntity::call('couple'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDogRequest $request, string $id)
    {
        $data = $request->validated();
        $data['avatar'] = $this->storeAvatar($request);
        UpdateDog::call($id, $data);

        return redirect()->route('dogs.index')->with('toast', 'Dog updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DeleteDog::call($id);

        return response()->noContent();
    }

    protected function storeAvatar(UpdateDogRequest|StoreDogRequest $request)
    {
        if ($request->file('avatar') == null) {
            return null;
        }

        return $request->file('avatar')->storePublicly('public/avatars');
    }
}

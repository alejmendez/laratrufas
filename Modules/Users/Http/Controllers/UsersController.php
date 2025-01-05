<?php

namespace Modules\Users\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Users\Http\Requests\StoreUserRequest;
use Modules\Users\Http\Requests\UpdateUserRequest;
use Modules\Users\Http\Resources\UserResource;
use App\Services\Entities\ListEntity;
use Modules\Users\Services\CreateUser;
use Modules\Users\Services\DeleteUser;
use Modules\Users\Services\FindUser;
use Modules\Users\Services\ListUser;
use Modules\Users\Services\UpdateUser;
use Inertia\Inertia;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->exists('dt_params')) {
            $params = json_decode(request('dt_params', '[]'), true);

            return response()->json(ListUser::call($params));
        }

        return Inertia::render('Users/List', [
            'toast' => session('toast'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Users/Create', [
            'roles' => ListEntity::call('role'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $data['avatar'] = $this->storeAvatar($request);
        CreateUser::call($data);

        return redirect()->route('users.index')->with('toast', 'User created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = FindUser::call($id);

        return Inertia::render('Users/Show', [
            'data' => new UserResource($user),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = FindUser::call($id);

        return Inertia::render('Users/Edit', [
            'data' => new UserResource($user),
            'roles' => ListEntity::call('role'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $data = $request->validated();
        $data['avatar'] = $this->storeAvatar($request);
        UpdateUser::call($id, $data);

        return redirect()->route('users.index')->with('toast', 'User updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DeleteUser::call($id);

        return response()->noContent();
    }

    protected function storeAvatar(UpdateUserRequest|StoreUserRequest $request)
    {
        if ($request->file('avatar') == null) {
            return null;
        }

        return $request->file('avatar')->storePublicly('public/avatars');
    }
}

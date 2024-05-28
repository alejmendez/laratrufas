<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use App\Services\Users\FindUser;
use App\Services\Users\ListUser;
use App\Services\Users\CreateUser;
use App\Services\Users\UpdateUser;
use App\Services\Users\DeleteUser;

use App\Services\Roles\ListRole;

use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order = request('order', '');
        $search = request('search', '');
        $users = ListUser::call($order, $search);

        return Inertia::render('Users/List', [
            'order' => $order,
            'search' => $search,
            'toast' => session('toast'),
            'data' => new UserCollection($users->paginate()->withQueryString()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Users/Create', [
            'roles' => $this->getSelectRoles(),
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
            'roles' => $this->getSelectRoles(),
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
            'roles' => $this->getSelectRoles(),
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
        return redirect()->back();
    }

    protected function storeAvatar(UpdateUserRequest | StoreUserRequest $request)
    {
        if (!$request->hasFile('avatar')) {
            return null;
        }

        return $request->file('avatar')->storePublicly('public/avatars');
    }

    protected function getSelectRoles()
    {
        return collect(ListRole::call())->map(fn($r) => [ 'value' => $r->name, 'text' => $r->name ]);
    }
}

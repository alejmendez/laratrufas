<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use App\Services\Dogs\FindDog;
use App\Services\Dogs\ListDog;
use App\Services\Dogs\CreateDog;
use App\Services\Dogs\UpdateDog;
use App\Services\Dogs\DeleteDog;
use App\Services\Fields\ListField;
use App\Services\Quarters\ListQuarter;
use App\Services\Users\ListUser;

use App\Http\Resources\DogResource;
use App\Http\Resources\DogCollection;
use App\Http\Requests\StoreDogRequest;
use App\Http\Requests\UpdateDogRequest;

class DogsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order = request('order', '');
        $search = request('search', '');
        $dogs = ListDog::call($order, $search);

        return Inertia::render('Dogs/List', [
            'order' => $order,
            'search' => $search,
            'toast' => session('toast'),
            'data' => new DogCollection($dogs->paginate()->withQueryString()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Dogs/Create', [
            'fields' => $this->getSelectFields(),
            'quarters' => $this->getSelectQuarters(),
            'couples' => $this->getSelectCouples(),
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

        return Inertia::render('Dogs/Show', [
            'data' => new DogResource($dog),
            'fields' => $this->getSelectFields(),
            'quarters' => $this->getSelectQuarters(),
            'couples' => $this->getSelectCouples(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dog = FindDog::call($id);

        return Inertia::render('Dogs/Edit', [
            'data' => new DogResource($dog),
            'fields' => $this->getSelectFields(),
            'quarters' => $this->getSelectQuarters(),
            'couples' => $this->getSelectCouples(),
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
        return redirect()->back();
    }

    protected function storeAvatar(UpdateDogRequest | StoreDogRequest $request)
    {
        if (!$request->hasFile('avatar')) {
            return null;
        }

        return $request->file('avatar')->store(options: 'avatars');
    }

    protected function getSelectFields()
    {
        return collect(ListField::call('name')->get())->map(fn($field) => [ 'value' => $field->id, 'text' => $field->name ]);
    }

    protected function getSelectQuarters()
    {
        return collect(ListQuarter::call('name')->get())->map(fn($quarter) => [ 'value' => $quarter->id, 'text' => $quarter->name, 'field_id' => $quarter->field_id ]);
    }

    protected function getSelectCouples()
    {
        return collect(ListUser::call('name')->get())
            ->map(fn($couple) => [ 'value' => $couple->id, 'text' => $couple->full_name ]);
    }
}

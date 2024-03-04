<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

use App\Services\Fields\ListField;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Dashboard/Index', [
            'fields' => $this->getSelectFields(),
        ]);
    }

    protected function getSelectFields()
    {
        return collect(ListField::call('name')->get())->map(fn($field) => [ 'value' => $field->id, 'text' => $field->name ]);
    }
}

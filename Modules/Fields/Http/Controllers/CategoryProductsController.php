<?php

namespace Modules\Fields\Http\Controllers;

use Modules\Core\Http\Controllers\Controller;
use Modules\Fields\Http\Requests\StoreCategoryProductRequest;
use Modules\Fields\Http\Requests\UpdateCategoryProductRequest;
use Modules\Fields\Services\CategoryProducts\CreateCategoryProduct;
use Modules\Fields\Services\CategoryProducts\DeleteCategoryProduct;
use Modules\Fields\Services\CategoryProducts\ListCategoryProduct;
use Modules\Fields\Services\CategoryProducts\UpdateCategoryProduct;
use Inertia\Inertia;
use Modules\Core\Traits\HasPermissionMiddleware;

class CategoryProductsController extends Controller
{
    use HasPermissionMiddleware;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->exists('dt_params')) {
            $params = json_decode(request('dt_params', '[]'), true);

            return response()->json(ListCategoryProduct::call($params));
        }

        return Inertia::render('Fields::CategoryProducts/List');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryProductRequest $request)
    {
        $data = $request->validated();
        CreateCategoryProduct::call($data);

        return [
            'success' => true,
            'message' => 'Category Product created.',
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryProductRequest $request, string $id)
    {
        $data = $request->validated();
        UpdateCategoryProduct::call($id, $data);

        return [
            'success' => true,
            'message' => 'Category Product updated.',
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DeleteCategoryProduct::call($id);
        return response()->noContent();
    }
}

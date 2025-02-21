<?php

namespace Modules\Fields\Services\CategoryProducts;

use Modules\Fields\Models\CategoryProduct;
use Modules\Core\Services\PrimevueDatatables;

class ListCategoryProduct
{
    public static function call($params = [])
    {
        $searchableColumns = ['name', 'is_commercial'];

        $query = CategoryProduct::query();

        $datatable = new PrimevueDatatables($params, $searchableColumns);
        $CategoryProducts = $datatable->of($query)->make();

        return $CategoryProducts;
    }
}

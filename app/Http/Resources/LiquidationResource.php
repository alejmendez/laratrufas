<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LiquidationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'week' => $this->week,
            'year' => $this->year,
            'delivery_date' => $this->delivery_date,
            'reception_date' => $this->reception_date,
            'weight_with_earth' => $this->weight_with_earth,
            'weight_washed' => $this->weight_washed,
            'dollar_value' => $this->dollar_value,
            'importer_id' => [
                'value' => $this->importer->id,
                'text' => $this->importer->name,
            ],
            'products' => $this->liquidationProducts->mapWithKeys(function ($liquidationProduct, $key) {
                return [$liquidationProduct->id => [
                    'id' => $liquidationProduct->id,
                    'key' => $liquidationProduct->category_product_id,
                    'category_product_id' => $liquidationProduct->category_product_id,
                    'name' => $liquidationProduct->categoryProduct->name,
                    'price' => $liquidationProduct->price,
                    'weight' => $liquidationProduct->weight,
                ]];
            }),
        ];
    }
}

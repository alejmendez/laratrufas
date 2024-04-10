<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class HarvestResource extends JsonResource
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
            'batch' => $this->batch,
            'dog' => [
                'id' => $this->dog->id,
                'name' => $this->dog->name,
            ],
            'farmer' => [
                'id' => $this->farmer->id,
                'name' => $this->farmer->name,
            ],
            'assistant' => [
                'id' => $this->assistant->id,
                'name' => $this->assistant->name,
            ],
            'quarters' => $this->quarters->map(function ($quarter) {
                return [
                    'id' => $quarter->id,
                    'name' => $quarter->name,
                ];
            }),
            'detail' => $this->details->map(function ($detail) {
                return [
                    'plant_code' => $detail->plant->plant,
                    'quality' => $detail->quality,
                    'weight' => $detail->weight,
                ];
            }),
        ];
    }
}

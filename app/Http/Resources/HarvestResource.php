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
            'comments' => $this->comments,
            'dog_id' => $this->dog_id,
            'farmer_id' => $this->farmer_id,
            'assistant_id' => $this->assistant_id,
            'detail' => $this->details->map(function ($detail) {
                return [
                    'plant' => [
                        'id' => $detail->plant_id,
                        'code' => $detail->plant->plant
                    ],
                    'number' => $detail->number,
                    'quality' => $detail->quality,
                    'weight' => $detail->weight,
                ];
            }),
            'quarters' => $this->details->map(function ($detail) {
                $quearter = $detail->plant->quearter;
                return [
                    'id' => $quearter->id,
                    'name' => $quearter->name,
                ];
            })->unique('id'),
            'quarters' => $this->details->map(function ($detail) {
                $field = $detail->plant->quearter->field;
                return [
                    'id' => $field->id,
                    'name' => $field->name,
                ];
            })->unique('id'),
        ];
    }
}

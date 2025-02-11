<?php

namespace Modules\Fields\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'year' => $this->year,
            'week' => $this->week,
            'batch' => $this->batch,
            'dog' => [
                'id' => optional($this->dog)->id,
                'name' => optional($this->dog)->name,
            ],
            'farmer' => [
                'id' => optional($this->farmer)->id,
                'name' => optional($this->farmer)->name,
            ],
            'assistant' => [
                'id' => optional($this->assistant)->id,
                'name' => optional($this->assistant)->name,
            ],
            'quarters' => $this->quarters->map(fn ($quarter) => [
                'id' => optional($quarter)->id,
                'name' => optional($quarter)->name,
            ]),
            'fields' => $this->quarters->map(fn ($quarter) => [
                'id' => optional($quarter)->id,
                'name' => optional($quarter)->name,
            ]),
            'details' => $this->details->filter(fn ($detail) => $detail->plant)->map(fn ($detail) => [
                'id' => $detail->id,
                'plant_id' => optional($detail->plant)->id,
                'plant_code' => optional($detail->plant)->code,
                'quality' => $detail->quality,
                'weight' => $detail->weight,
            ]),
        ];
    }
}

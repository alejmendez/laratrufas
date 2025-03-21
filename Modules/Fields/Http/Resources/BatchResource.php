<?php

namespace Modules\Fields\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BatchResource extends JsonResource
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
            'batch_number' => $this->batch_number,
            'delivery_date' => $this->delivery_date,
            'importer_id' => [
                'value' => optional($this->importer)->id,
                'text' => optional($this->importer)->name,
            ],
            'harvests' => $this->harvests->pluck('id'),
        ];
    }
}

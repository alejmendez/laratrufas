<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class HarvestListResource extends JsonResource
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
            'year' => $harvest->year,
            'week' => $harvest->week,
            'batch' => $this->batch,
            'field_names' => $this->quarters->map(fn ($quarter) => $quarter->field->name)->unique()->join(', '),
            'quarter_names' => $this->quarters->map(fn ($quarter) => $quarter->name)->unique()->join(', '),
            'total_weight' => $this->details->map(fn ($detail) => $detail->weight)->sum(),
            'unit_count' => $this->details->count(),
            'farmer_name' => $this->farmer->name,
        ];
    }
}

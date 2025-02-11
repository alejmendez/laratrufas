<?php

namespace Modules\Fields\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PlantResource extends JsonResource
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
            'name' => $this->name,
            'plant_type' => [
                'id' => optional($this->plant_type)->id,
                'name' => optional($this->plant_type)->name,
            ],
            'age' => $this->age,
            'planned_at' => $this->planned_at,
            'nursery_origin' => $this->nursery_origin,
            'code' => $this->code,
            'row' => $this->row,
            'blueprint' => $this->blueprint ? Storage::url($this->blueprint) : '',
            'field' => [
                'id' => optional($this->quarter->field)->id,
                'name' => optional($this->quarter->field)->name,
            ],
            'quarter' => [
                'id' => optional($this->quarter)->id,
                'name' => optional($this->quarter)->name,
            ],
            'responsible' => [
                'id' => optional($this->quarter->responsible)->id,
                'name' => optional($this->quarter->responsible)->full_name,
            ],
        ];
    }
}

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
                'id' => $this->plant_type->id,
                'name' => $this->plant_type->name,
            ],
            'age' => $this->age,
            'planned_at' => $this->planned_at,
            'nursery_origin' => $this->nursery_origin,
            'code' => $this->code,
            'row' => $this->row,
            'blueprint' => $this->blueprint ? Storage::url($this->blueprint) : '',
            'field' => [
                'id' => $this->quarter->field->id,
                'name' => $this->quarter->field->name,
            ],
            'quarter' => [
                'id' => $this->quarter->id,
                'name' => $this->quarter->name,
            ],
            'responsible' => [
                'id' => $this->quarter->responsible->id,
                'name' => $this->quarter->responsible->full_name,
            ],
        ];
    }
}

<?php

namespace Modules\Field\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlantDetailResource extends JsonResource
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
            'type' => $this->type,
            'value' => $this->value,
            'is_active' => $this->is_active,
            'updated_at' => $this->updated_at,
        ];
    }
}

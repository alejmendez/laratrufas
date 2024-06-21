<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class FieldResource extends JsonResource
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
            'location' => $this->location,
            'size' => $this->size,
            'plants_count' => $this->plants->count(),
            'quarters_count' => $this->quarters->count(),
            'blueprint' => $this->blueprint ? Storage::url($this->blueprint) : '',
            'owner' => [
                'dni' => $this->owner_dni,
                'name' => $this->owner_name,
            ],
        ];
    }
}

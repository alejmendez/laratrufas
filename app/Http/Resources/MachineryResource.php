<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class MachineryResource extends JsonResource
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
            'purchase_date' => $this->purchase_date,
            'last_maintenance' => $this->last_maintenance,
            'purchase_location' => $this->purchase_location,
            'type' => $this->type,
            'contact' => $this->contact,
        ];
    }
}

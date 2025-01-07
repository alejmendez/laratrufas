<?php

namespace Modules\Field\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class QuarterResource extends JsonResource
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
            'area' => $this->area,
            'plants_count' => $this->plants->count(),
            'blueprint' => $this->blueprint ? Storage::url($this->blueprint) : '',
            'field' => [
                'id' => $this->field->id,
                'name' => $this->field->name,
            ],
            'responsible' => [
                'id' => $this->responsible->id,
                'name' => $this->responsible->full_name,
            ],
        ];
    }
}

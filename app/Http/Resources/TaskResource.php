<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class TaskResource extends JsonResource
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
            'repeat' => $this->repeat,
            'status' => $this->status,
            'priority' => $this->priority,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'field_id' => $this->field_id,
            'quarter_id' => $this->quarter_id,
            'plant_id' => $this->plant_id,
            'responsible_id' => $this->responsible_id,
            'note' => $this->note,
            'comments' => $this->comments,
            // Additional validation rules for related tables
            'tools' => $this->tools->pluck('id'),
            'equipments' => $this->equipments->pluck('id'),
            'supplies' =>  $this->supplies->map(fn ($supply) => [
                'id' => $supply->id,
                'name' => $supply->name,
                'brand' => $supply->brand,
                'quantity' => $supply->quantity,
                'unit' => $supply->unit,
            ]),
        ];
    }
}

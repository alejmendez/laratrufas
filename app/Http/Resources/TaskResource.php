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
            'repeat_number' => $this->repeat_number,
            'repeat_type' => $this->repeat_type,
            'status' => $this->status,
            'priority' => $this->priority,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'field' => [
                'value' => $this->field->id,
                'text' => $this->field->name,
            ],
            'quarters' => $this->quarters->pluck('id'),
            'rows' => $this->rows,
            'plants' => $this->plants->pluck('id'),
            'responsible_id' => $this->responsible->id,
            'note' => $this->note,
            'comments' => $this->comments,
            // Additional validation rules for related tables
            'tools' => $this->tools->map(fn ($tool) => [
                'value' => $tool->id,
                'text' => $tool->name,
            ]),
            'machineries' => $this->machineries->map(fn ($machinery) => [
                'value' => $machinery->id,
                'text' => $machinery->name,
            ]),
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

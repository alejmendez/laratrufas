<?php

namespace Modules\Tasks\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'comments' => $this->comments->sortBy('created_at')->map(fn ($comment) => [
                'id' => $comment->id,
                'comment' => $comment->comment,
                'user_id' => $comment->user->id,
                'user_name' => $comment->user->full_name,
                'user_avatar' => $comment->user->avatar_url,
                'created_at' => $comment->created_at,
            ])->toArray(),
            // Additional validation rules for related tables
            'tools' => $this->tools->map(fn ($tool) => [
                'value' => $tool->id,
                'text' => $tool->name,
            ]),
            'security_equipments' => $this->security_equipments->map(fn ($security_equipment) => [
                'value' => $security_equipment->id,
                'text' => $security_equipment->name,
            ]),
            'machineries' => $this->machineries->map(fn ($machinery) => [
                'value' => $machinery->id,
                'text' => $machinery->name,
            ]),
            'supplies' => $this->supplies->map(fn ($supply) => [
                'id' => $supply->id,
                'name' => $supply->name,
                'brand' => $supply->brand,
                'quantity' => $supply->quantity,
                'unit' => $supply->unit,
            ]),
        ];
    }
}

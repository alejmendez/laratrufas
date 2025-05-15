<?php

namespace Modules\Fields\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
class BatchResource extends JsonResource
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
            'batch_number' => $this->batch_number,
            'delivery_date' => $this->delivery_date,
            'carrier' => $this->carrier ?? '',
            'field_name' => $this->harvests->first()->quarters->first()->field->name,
            'total_weight' => $this->harvests->sum('weight'),
            'current_weight' => $this->current_weight,
            'importer_name' => optional($this->importer)->name,
            'importer_id' => [
                'value' => optional($this->importer)->id,
                'text' => optional($this->importer)->name,
            ],
            'harvests_elements' => $this->harvests->map(function ($harvest) {
                return [
                    'id' => $harvest->id,
                    'date' => $harvest->date,
                    'weight' => $harvest->weight,
                    'batch' => trans('harvest.form.batch.renderText', [
                        'week' => $harvest->week,
                        'batch' => $harvest->batch,
                    ]),
                ];
            }),
            'harvests' => $this->harvests->pluck('id'),
        ];
    }
}

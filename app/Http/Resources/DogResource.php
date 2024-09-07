<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class DogResource extends JsonResource
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
            'breed' => $this->breed,
            'gender' => $this->gender,
            'birthdate' => $this->birthdate,
            'age' => $this->age,
            'veterinary' => $this->veterinary,
            'avatar' => $this->avatar ? Storage::url($this->avatar) : '',
            'field' => [
                'id' => $this->quarter->field->id,
                'name' => $this->quarter->field->name,
            ],
            'quarter' => [
                'id' => $this->quarter->id,
                'name' => $this->quarter->name,
            ],
            'couple' => [
                'id' => $this->couple->id,
                'name' => $this->couple->full_name,
            ],
            'vaccines' => $this->vaccines->map(function ($v) {
                return [
                    'id' => $v['id'],
                    'name' => $v['name'],
                    'date' => $v['date'],
                    'code' => $v['code'],
                ];
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

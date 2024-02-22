<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:80',
            'plant_type_id' => 'required|exists:plant_types,id',
            'age' => 'required|integer',
            'planned_at' => 'required|date_format:Y-m-d',
            'nursery_origin' => 'required|max:80',
            'code' => 'required|max:12',
            'row' => 'required|max:1',
            'field_id' => 'required|exists:fields,id',
            'quarter_id' => 'required|exists:quarters,id',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePlantRequest extends FormRequest
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
            'plant_type_id' => 'required|exists:plant_types,id',
            'age' => 'required|numeric|between:0,200',
            'planned_at' => 'required|date_format:Y-m-d',
            'nursery_origin' => 'required|max:80',
            'code' => ['required', 'max:12', Rule::unique('plants')],
            'row' => 'required|max:2',
            'field_id' => 'required|exists:fields,id',
            'quarter_id' => 'required|exists:quarters,id',
        ];
    }
}

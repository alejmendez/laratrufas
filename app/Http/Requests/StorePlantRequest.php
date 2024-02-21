<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'name' => 'required|max:250',
            'plant_type_id' => 'required|exists:plant_types,id',
            'age' => 'required|max:250',
            'planned_at' => 'required|date_format:Y-m-d',
            'nursery_origin' => 'required|max:250',
            'code' => 'required|max:250',
            'field_id' => 'required|exists:fields,id',
            'quarter_id' => 'required|exists:quarters,id',
            'row' => 'required|max:1',
        ];
    }
}

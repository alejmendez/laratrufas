<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'priority' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'field_id' => 'required|exists:fields,id',
            'quarter_id' => 'required|exists:quarters,id',
            'plant_id' => 'required|exists:plants,id',
            'responsible_id' => 'required|exists:users,id',
            'note' => 'nullable|string',
            'comments' => 'nullable|string',
            // Additional validation rules for related tables
            'tools' => 'nullable|array',
            'tools.*' => 'exists:tools,id',
            'equipments' => 'nullable|array',
            'equipments.*' => 'exists:equipments,id',
            'supplies' => 'nullable|array',
            'supplies.*.name' => 'required_with:supplies|string|max:255',
            'supplies.*.brand' => 'required_with:supplies|string|max:255',
            'supplies.*.quantity' => 'required_with:supplies|numeric|min:0',
            'supplies.*.unit' => 'required_with:supplies|string|max:255',
        ];
    }
}

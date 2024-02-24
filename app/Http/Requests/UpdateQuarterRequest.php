<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuarterRequest extends FormRequest
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
            'area' => 'required|integer',
            'location' => 'required|max:25',
            'planned_at' => 'required|date_format:Y-m-d',
            'field_id' => 'required|exists:fields,id',
            'responsible_id' => 'required|exists:users,id',
        ];
    }
}

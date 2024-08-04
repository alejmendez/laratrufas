<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDogRequest extends FormRequest
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
            'breed' => 'required|max:80',
            'gender.value' => [
                'required',
                Rule::in(['M', 'F']),
            ],
            'birthdate' => 'required|date',
            'quarter_id.value' => 'required|exists:quarters,id',
            'veterinary' => 'required|max:80',
            'couple_id.value' => 'required|exists:users,id',
            'avatar' => '',
            'avatarRemove' => 'boolean',
            'vaccines.*.name' => 'max:80',
            'vaccines.*.date' => 'date',
            'vaccines.*.code' => 'max:80',
        ];
    }
}

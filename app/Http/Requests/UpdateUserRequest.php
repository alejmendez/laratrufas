<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
        dd($this->dni);
        return [
            'name' => 'required|min:3|max:80',
            'last_name' => 'required|min:3|max:80',
            'email' => ['required', 'email', 'max:200', Rule::unique('users')->ignore($this->id)],
            'dni' => ['required', 'regex:/^\d?\d\.\d{3}\.\d{3}\-[\d|k|K]$/', Rule::unique('users')->ignore($this->id)],
            'phone' => 'required|min:11|max:20',
            'password' => [],
            'avatar' => '',
            'avatarRemove' => 'boolean',
        ];
    }
}

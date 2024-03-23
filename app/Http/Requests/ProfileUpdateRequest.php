<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:80',
            'last_name' => 'required|min:3|max:80',
            'email' => ['required', 'string', 'lowercase', 'email', 'max:200', Rule::unique(User::class)->ignore($this->id)],
            'dni' => ['required', 'regex:/^\d{1,2}\.\d{3}\.\d{3}\-[\d|k|K]$/', Rule::unique(User::class)->ignore($this->id)],
            'phone' => 'required|min:11|max:20',
            'password' => [],
        ];
    }
}

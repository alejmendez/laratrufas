<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateToolRequest extends FormRequest
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
            'purchase_date' => 'required|date',
            'last_maintenance' => 'required|date',
            'purchase_location' => 'required|max:80',
            'type' => 'required|max:80',
            'contact' => 'required|max:80',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nombre',
            'purchase_date' => 'fecha de compra',
            'last_maintenance' => 'fecha de última mantención',
            'purchase_location' => 'lugar de compra',
            'type' => 'tipo',
            'contact' => 'contacto',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHarvestRequest extends FormRequest
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
            'date' => 'required|date_format:Y-m-d',
            'batch' => 'required|max:2',
            'comments' => 'required|max:250',
            'dog_id' => 'required|exists:dogs,id',
            'farmer_id' => 'required|exists:users,id',
            'assistant_id' => 'required|exists:users,id',
            'details.*.plant_id' => 'required|exists:plants,id',
            'details.*.number' => 'required|integer',
            'details.*.quality' => 'required|integer',
            'details.*.weight' => 'required|numeric|between:0,99999',
        ];
    }
}

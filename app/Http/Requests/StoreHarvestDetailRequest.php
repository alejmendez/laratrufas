<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Services\HarvestDetails\ListHarvestQualities;

class StoreHarvestDetailRequest extends FormRequest
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
            'plant_code' => 'exists:plants,code',
            'quality' => Rule::in(ListHarvestQualities::call('values')),
            'weight' => 'numeric|between:0,99999',
        ];
    }
}

<?php

namespace Modules\Fields\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBatchRequest extends FormRequest
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
            'batch_number' => 'required|string|max:255|unique:batches,batch_number',
            'delivery_date' => 'required|date',
            'importer_id' => 'required',
            'importer_id.value' => 'required|exists:importers,id',
            'harvests' => 'required|array',
            'harvests.*.value' => 'exists:harvests,id',
            'carrier' => 'string|max:255',
        ];
    }

    public function attributes()
    {
        return [
            'batch_number' => 'batch n°',
            'delivery_date' => 'Fecha de entrega',
            'importer_id' => 'Importador',
            'harvests' => 'cosechas',
            'carrier' => 'Empresa de cargo o envío',
        ];
    }
}

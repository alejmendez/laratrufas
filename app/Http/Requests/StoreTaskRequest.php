<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'status' => 'required',
            'status.value' => 'required|string',
            'priority' => 'required',
            'priority.value' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'field_id' => 'required',
            'field_id.value' => 'required|exists:fields,id',
            'quarter_id' => 'required',
            'quarter_ids.*.value' => 'integer|exists:quarters,id',
            'plant_id' => 'required',
            'plant_id.*.value' => 'integer|exists:plants,id',
            'rows' => 'required',
            'rows.*.value' => 'string',
            'responsible_id' => 'required',
            'responsible_id.value' => 'required|exists:users,id',
            'comments' => 'nullable|string',
            // Additional validation rules for related tables
            'tools' => 'nullable|array',
            'tools.*.value' => 'exists:tools,id',
            'security_equipments' => 'nullable|array',
            'security_equipments.*.value' => 'exists:security_equipments,id',
            'machineries' => 'nullable|array',
            'machineries.*.value' => 'exists:machineries,id',
            'supplies' => 'nullable|array',
            'supplies.*.name' => 'required_with:supplies|string|max:255',
            'supplies.*.brand' => 'required_with:supplies|string|max:255',
            'supplies.*.quantity' => 'required_with:supplies|numeric|min:0',
            'supplies.*.unit' => 'required_with:supplies',
            'supplies.*.unit.value' => 'string',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nombre',
            'status' => 'estado',
            'repeat_number' => 'número de repetición',
            'repeat_type' => 'tipo de repetición',
            'priority' => 'prioridad',
            'start_date' => 'fecha inicio',
            'end_date' => 'fecha fin',
            'field_id' => 'campo',
            'quarter_id' => 'cuartel',
            'plant_id' => 'planta',
            'responsible_id' => 'responsable',
            'comments' => 'comentarios',
            'tools' => 'herramientas',
            'security_equipments' => 'equipos de seguridad',
            'machineries' => 'maquinarias',
            'supplies.*.name' => 'suministros.*.nombre',
            'supplies.*.brand' => 'suministros.*.marca',
            'supplies.*.quantity' => 'suministros.*.cantidad',
            'supplies.*.unit' => 'suministros.*.unidad',
        ];
    }
}

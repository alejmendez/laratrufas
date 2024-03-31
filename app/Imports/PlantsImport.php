<?php

namespace App\Imports;

use App\Models\Plant;
use App\Models\PlantType;

use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;

use Illuminate\Validation\Rule;

class PlantsImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;

    protected $quarter_id;
    protected $plant_types;

    public function __construct($quarter_id) {
        $this->quarter_id = $quarter_id;
        $this->plant_types = PlantType::all()->pluck('id', 'slug')->toArray();
    }

    public function model(array $row)
    {
        return new Plant([
            'quarter_id'     => $this->quarter_id,
            'code'           => $row['codigo'],
            'row'            => $row['hilera'],
            'plant_type_id'  => $this->getPlantTypeIdByName($row['tipo_de_planta']),
            'planned_at'     => $row['fecha_de_plantacion'],
            'nursery_origin' => $row['vivero_de_origen'],
        ]);
    }

    public function getPlantTypeIdByName($name)
    {
        $slug = Str::slug($name);

        if (isset($this->plant_types[$slug])) {
            $plant_type_id = $this->plant_types[$slug];
        } else {
            $plant_type = PlantType::create(['name' => $name, 'slug' => $slug]);
            $this->plant_types[$slug] = $plant_type->id;
            $plant_type_id = $plant_type->id;
        }

        return $plant_type_id;
    }

    public function rules(): array
    {
        return [
            'codigo' => ['required', 'max:12', Rule::unique('plants')],
            'hilera' => 'required|max:2',
            'tipo_de_planta' => 'required|max:20',
            'fecha_de_plantacion' => 'required|date_format:Y-m-d',
            'vivero_de_origen' => 'required|max:80',
        ];
    }

}

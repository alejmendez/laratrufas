<?php

namespace App\Imports;

use App\Models\Plant;
use Illuminate\Support\Str;

use App\Models\HarvestDetail;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Services\Plants\FindPlantByCode;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;


class HarvestsImport implements ToModel, WithHeadingRow, SkipsEmptyRows, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    protected $rowCount = 0;
    protected $numberOfUnprocessedRecords = 0;
    protected $harvest_id;

    public function __construct($harvest_id) {
        $this->harvest_id = intval($harvest_id);
    }

    public function model(array $row)
    {
        $row['codigo_de_planta'] = strtoupper(trim($row['codigo_de_planta']));

        $harvest_detail = new HarvestDetail;
        $harvest_detail->harvest_id = $this->harvest_id;
        $harvest_detail->plant_id = $this->getPlantIdByCode($row['codigo_de_planta']);
        $harvest_detail->quality = Str::slug($row['calidad']);
        $harvest_detail->weight = $row['peso'];

        $count = HarvestDetail::where([
            'harvest_id' => $harvest_detail->harvest_id,
            'plant_id' => $harvest_detail->plant_id,
            'quality' => $harvest_detail->quality,
            'weight' => $harvest_detail->weight,
        ])->count();

        if ($count > 0) {
            $this->numberOfUnprocessedRecords++;
            return null;
        }

        $this->rowCount++;

        return $harvest_detail;
    }

    public function getPlantIdByCode($code)
    {
        return optional(FindPlantByCode::call($code), fn (Plant $plant) => $plant->id);
    }

    public function rules(): array
    {
        return [
            'codigo_de_planta' => [
                'required',
                Rule::exists('plants', 'code')
            ],
            'calidad' => 'max:30|nullable',
            'peso' => 'required|numeric|between:0,99999',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'codigo_de_planta.exists' => 'El código de planta ":input" no existe.',
            'calidad.max' => 'La cantidad ":input" es inválido, debe tener un maximo de 30 caracteres.',
            'peso.numeric' => 'El peso ":input" debe ser un numero.',
            'peso.between' => 'El peso ":input" debe estar entre 0 y 99999.',
        ];
    }

    public function prepareForValidation($data, $index)
    {
        $data['codigo_de_planta'] = strtoupper(trim($data['codigo_de_planta'] ?? ''));
        return $data;
    }

    public function getRowCount()
    {
        return $this->rowCount;
    }

    public function getNumberOfUnprocessedRecords()
    {
        return $this->numberOfUnprocessedRecords;
    }
}

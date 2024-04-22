<?php

namespace App\Imports;

use App\Models\Plant;
use App\Models\HarvestDetail;

use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use App\Services\Plants\FindPlantByCode;

use Illuminate\Validation\Rule;

class HarvestsImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;

    protected $harvest_id;

    public function __construct($harvest_id) {
        $this->harvest_id = $harvest_id;
    }

    public function model(array $row)
    {
        return new HarvestDetail([
            'harvest_id' => $this->harvest_id,
            'plant_id'   => $this->getPlantIdByCode($row['codigo_de_planta']),
            'quality'    => Str::slug($row['calidad']),
            'weight'     => $row['peso'],
        ]);
    }

    public function getPlantIdByCode($code)
    {
        return optional(FindPlantByCode::call($code), fn (Plant $plant) => $plant->id);
    }

    public function rules(): array
    {
        return [
            'codigo_de_planta' => 'required|exists:plants,code',
            'calidad' => 'required|max:30',
            'peso' => 'required|numeric|between:0,99999',
        ];
    }

}

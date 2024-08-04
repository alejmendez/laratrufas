<?php

namespace App\Imports;

use App\Models\Plant;
use App\Models\HarvestDetail;

use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Events\AfterImport;
use Illuminate\Support\Facades\Validator;
use App\Services\Plants\FindPlantByCode;

use Illuminate\Validation\Rule;

class HarvestsImport implements ToModel, WithHeadingRow, WithEvents
{
    use Importable, RegistersEventListeners;

    private $rowCount = 0;
    protected $harvest_id;

    public function __construct($harvest_id) {
        $this->harvest_id = $harvest_id;
    }

    public function model(array $row)
    {
        $row['codigo_de_planta'] = strtoupper(trim($row['codigo_de_planta']));

        Validator::make($row, [
            'codigo_de_planta' => 'required|exists:plants,code',
            'calidad' => 'max:30|nullable',
            'peso' => 'required|numeric|between:0,99999',
        ])->validate();

        $this->rowCount++;

        $harvest_detail = new HarvestDetail;
        $harvest_detail->harvest_id = $this->harvest_id;
        $harvest_detail->plant_id = $this->getPlantIdByCode($row['codigo_de_planta']);
        $harvest_detail->quality = Str::slug($row['calidad']);
        $harvest_detail->weight = $row['peso'];

        return $harvest_detail;
    }

    public function getPlantIdByCode($code)
    {
        return optional(FindPlantByCode::call($code), fn (Plant $plant) => $plant->id);
    }

    public static function afterImport(AfterImport $event)
    {
        $import = $event->getConcernable();
        session(['rowCount' => $import->rowCount]);
    }

    public function getRowCount()
    {
        return $this->rowCount;
    }
}

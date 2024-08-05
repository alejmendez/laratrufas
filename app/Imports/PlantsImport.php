<?php

namespace App\Imports;

use App\Models\Plant;
use App\Models\PlantType;

use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Events\AfterImport;

use Illuminate\Validation\Rule;

class PlantsImport implements ToModel, WithHeadingRow, WithValidation, WithEvents
{
    use Importable, RegistersEventListeners;

    private $rowCount = 0;

    protected $quarter_id;
    protected $plant_types;

    public function __construct($quarter_id) {
        $this->quarter_id = $quarter_id;
        $this->plant_types = PlantType::all()->pluck('id', 'slug')->toArray();
    }

    public function model(array $row)
    {
        $this->rowCount++;
        $plant = new Plant;
        $plant->quarter_id = $this->quarter_id;
        $plant->code = $row['codigo'];
        $plant->row = $row['hilera'];
        $plant->age = $row['edad'];
        $plant->plant_type_id = $this->getPlantTypeIdByName($row['tipo_de_planta']);
        $plant->planned_at = $row['fecha_de_plantacion'];
        $plant->nursery_origin = $row['vivero_de_origen'];
        return $plant;
    }

    public function getPlantTypeIdByName($name)
    {
        $slug = Str::slug($name);

        if (isset($this->plant_types[$slug])) {
            $plant_type_id = $this->plant_types[$slug];
        } else {
            $plant_type = new PlantType;
            $plant_type->name = $name;
            $plant_type->slug = $slug;
            $plant_type->save();

            $this->plant_types[$slug] = $plant_type->id;
            $plant_type_id = $plant_type->id;
        }

        return $plant_type_id;
    }

    public function rules(): array
    {
        return [
            'codigo' => ['required', 'max:12', Rule::unique('plants', 'code')],
            'hilera' => 'required|max:2',
            'edad' => 'required|max:3',
            'tipo_de_planta' => 'required|max:20',
            'fecha_de_plantacion' => 'required|date_format:Y-m-d',
            'vivero_de_origen' => 'required|max:80',
        ];
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

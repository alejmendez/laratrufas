<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class HarvestsTemplateExport implements FromArray
{
    public function array(): array
    {
        return [
            ['Código de planta', 'Calidad', 'Peso'],
            ['FL01AA12', 'Regular', '3']
        ];
    }
}

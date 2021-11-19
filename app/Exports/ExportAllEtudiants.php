<?php

namespace App\Exports;

use App\Formation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ExportAllEtudiants implements WithMultipleSheets
{
    public function __construct($type)
    {
        $this->type = $type;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function sheets(): array
    {
        $sheets = [];
        $formations = Formation::get();
        foreach($formations as $f){
            $sheets[] = new EtudiantsExport($f,$this->type);
        }
        return $sheets;

    }
}

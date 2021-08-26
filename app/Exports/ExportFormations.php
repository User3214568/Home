<?php

namespace App\Exports;

use App\Formation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ExportFormations implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function sheets():array
    {
        $sheets = [];
        foreach(Formation::get() as $formation){
            $sheets [] = new EtudiantsExport($formation->id);
        }
        return $sheets;
    }
}

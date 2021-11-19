<?php

namespace App\Exports;

use App\Formation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ExportAllProfesseurs implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function sheets(): array
    {
        $sheets = [];
        $formations = Formation::orderBy('name','ASC')->get();

        foreach($formations as $formation){
            $sheets[] = new ExportProfesseur($formation);
        }

        return $sheets;
    }
}

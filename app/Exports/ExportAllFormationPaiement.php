<?php

namespace App\Exports;

use App\Formation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ExportAllFormationPaiement implements WithMultipleSheets
{


    public function sheets(): array
    {
        $sheets = [];
        $formations = Formation::orderBy('name','ASC')->get();

        foreach($formations as $formation){
            $sheets[] = new ExportFormationPaiement($formation,false);
        }

        return $sheets;
    }
}

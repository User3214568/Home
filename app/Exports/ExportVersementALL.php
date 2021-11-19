<?php

namespace App\Exports;

use App\Formation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ExportVersementALL implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function sheets(): array
    {
        $sheets = [];
        $formations = Formation::get();
        foreach ($formations as $formation) {
            $sheets [] = new FormationVersementsExport($formation);
        }
        return $sheets;
    }
}

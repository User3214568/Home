<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportPaiementProf extends TemplateExport implements FromCollection
{
    public function __construct($formation)
    {
        $this->formation = $formation;
        $paiements = $this->formation->paiements->sortBy('date_payement')->groupBy('date_payement');
    }

    public function additionalStyles(Worksheet $sheet, $styles)
    {

    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return null;
    }

}

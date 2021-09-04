<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class ExportFormationPaiement implements FromCollection
{
    public function __construct($formation)
    {
        $this->formation = $formation;
        $this->paiements = $this->formation->paiements->groupBy('date_payement');
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

    }
}

<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportEmptyFormationPaiement extends TemplateExport implements FromView,WithTitle,WithColumnWidths
{
    public function __construct($formation)
    {
        $this->formation = $formation;
        parent::__construct($formation->name,'Paiement des Professeurs',2);
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function additionalStyles(Worksheet $sheet, $styles)
    {
        $styles["11"] = [];
        for ($i=0; $i < 2 ; $i++) {
            $styles[chr(65+$i)."11"] = [];
        }
        return $styles;
    }
    public function view(): View
    {
        return view('parts.admin.finance.empty-paiement',['formation'=>$this->formation]);
    }
    public function columnWidths(): array
    {
        return [
            'A'=>60,'B'=>40
        ];
    }
    public function title(): string
    {
        return $this->formation->name;
    }
}

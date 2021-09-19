<?php

namespace App\Exports;

use App\Formation;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportFormationPaiement extends TemplateExport implements FromView,WithTitle,WithColumnWidths ,WithStartRow
{
    public function __construct($formation,$type)
    {
        $this->formation = $formation;
        $this->paiements = $this->formation->paiements->groupBy('date_payement');
        $this->header_size = 3;
        parent::__construct($formation->name,"Liste des Paiements des Professeurs",$this->header_size);
    }
    public function additionalStyles(Worksheet $sheet, $styles)
    {
            $styles['11'] = [];
            return $styles;
    }
    public function view(): View
    {
        return view('parts.admin.finance.paiements-table',['id'=>$this->formation->id]);
    }
    public function startRow(): int
    {
        return 11;
    }
    public function columnWidths(): array
    {
        $w = ['A'=>30,'B'=>50,'C'=>15];
        return $w;
    }
    public function title(): string
    {
        return $this->formation->name;
    }
}

<?php

namespace App\Exports;

use App\Http\Controllers\DepensesController;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportDepenses extends TemplateExport implements FromView,WithColumnWidths,WithMapping,WithHeadings,WithStartRow
{
    public function __construct()
    {
        parent::__construct("Dépenses Communes","Liste des Dépenses communes",3);
    }
    public function additionalStyles(Worksheet $sheet, $styles)
    {
        unset($styles["11"]);
        for ($i=0; $i < 3; $i++) {
            unset($styles[chr(65+$i)."11"]);
        }
        return $styles;
    }
    public function view(): View
    {
        $contnroller =  new DepensesController();
        return $contnroller->getDeps();
    }
    public function startRow(): int
    {
        return 11;
    }
    public function map($row): array
    {
        return [
            $row->name,
            $row->somme,
        ];
    }
    public function headings(): array
    {
        return [
            "Motif","Somme"
        ];
    }
    public function columnWidths(): array
    {
        return [
            'A'=>40,
            'B'=>25,
            'C'=>20
        ];
    }

}

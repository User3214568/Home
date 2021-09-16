<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportDepensesEmpty extends TemplateExport implements FromCollection,WithHeadings,WithColumnWidths
{
    public function __construct()
    {
        parent::__construct("Dépenses Communes","",2);
    }
    public function additionalStyles(Worksheet $sheet, $styles)
    {
        return $styles;
    }
    public function columnWidths(): array
    {
        return [
            'A'=>80,
            'B'=>15
        ];
    }
    public function headings(): array
    {
        return [
            "Motif","Somme"
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return new Collection();
    }
}

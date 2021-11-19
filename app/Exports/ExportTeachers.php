<?php

namespace App\Exports;

use App\Teacher;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportTeachers extends TemplateExport implements FromCollection,WithMapping,WithHeadings,WithColumnWidths
{
    public function __construct($empty=false)
    {
        $this->empty = $empty;
        parent::__construct("Liste des Professeurs","",5);
    }
    public function additionalStyles(Worksheet $sheet, $styles)
    {
        return $styles;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Teacher::get();
    }
    public function headings(): array
    {
        return[
            'CIN',
            'Nom',
            'Prenom',
            'Telephone',
            'Email'
        ];
    }
    public function map($teacher): array
    {
        if(!$this->empty){

            return [
                $teacher->user->cin,
                $teacher->user->firs_name,
                $teacher->user->last_name,
                $teacher->user->phone,
                $teacher->user->email,
            ];

        }else return [];
    }
    public function columnWidths(): array
    {
        $array = [
            'A'=>30,
            'B'=> 40,
            'C'=> 40,
            'D'=> 40,
            'E'=> 40,


        ];

        return $array;
    }
}

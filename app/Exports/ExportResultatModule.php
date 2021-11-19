<?php

namespace App\Exports;

use App\Utilities\Validation;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportResultatModule extends TemplateExport implements FromCollection,WithHeadings,WithColumnWidths,WithMapping,WithStartRow
{
    public function __construct($promotion,$session,$module ){
        $this->promotion = $promotion;
        $this->module = $module;
        $this->session = $session;
        parent::__construct($promotion->formation->name,"Résultat du Module ".$module->name,5,15);
        $this->start_row = 15;
        $this->header_size = 5;
    }
    public function additionalStyles(Worksheet $sheet, $styles)
    {
        $sheet->getCell('A12')->setValue('Module');
        $sheet->getCell('B12')->setValue($this->module->name);
        $sheet->getCell('A13')->setValue('Promotion');
        $sheet->getCell('B13')->setValue($this->promotion->nom);

        $sheet->getCell('D12')->setValue('Session');
        $sheet->getCell('E12')->setValue($this->session == 1 ?'Ordinaire':'Rattrappage');

        $styles['A12']=[
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE
                ],
            ],
            'font' => ['size' => 14 , 'bold' => true],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => 'd9d9d9']
            ]
        ];
        $styles['B12']=[
            'font' => ['size' => 14 , 'bold' => true],
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
            ],

        ];
        $styles['A13']  = $styles['A12'];
        $styles['D12']  = $styles['A12'];
        $styles['B13']  = $styles['B12'];
        $styles['E12']  = $styles['B12'];
        for ($i = $this->start_row; $i <= sizeof($this->promotion->etudiants)+$this->start_row; $i++) {
            for($j = 0 ; $j < $this->header_size ; $j++){
                $styles[(chr(65+$j)."$i")]['borders'] = [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE
                    ],
                ];
            }
        }
        for($i = $this->start_row ; $i <= sizeof($this->promotion->etudiants);$i++){
            $styles[$i]['font']['size'] = 14;
        }
        return $styles;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->promotion->etudiants;
    }
    public function headings(): array
    {
        return [
            "Nom",
            "Prénom",
            "CIN",
            "Date Naissance",
            "Résultat Final"
        ];
    }
    public function map($etudiant): array
    {
        if($etudiant->hasSession($this->module->id,$this->session)){

            return [
                $etudiant->user->first_name,
                $etudiant->user->last_name,
                $etudiant->user->cin,
                $etudiant->born_date,
                Validation::validateSessionModule($etudiant->cin,$this->module->id,$this->session)
            ];
        }else{
            return [];
        }
    }
    public function columnWidths(): array
    {
        return [
            'A'=>30,
            'B'=>30,
            'C'=>30,
            'D'=>30,
            'E'=>20,

        ];
    }
    public function startRow(): int
    {
        return 15;
    }
}

<?php

namespace App\Exports;

use App\Evaluation;
use App\Formation;
use App\Module;
use App\Semestre;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ModuleExport extends TemplateExport implements FromCollection,WithTitle,WithStrictNullComparison,WithColumnWidths,WithHeadings,WithMapping
{

    private $module;
    private $start_row ;
    private $header_size;
    private $session;
    private $isEmpty;
    public function __construct($sem_id,$id,$session,$empty = true){

        $this->promotion = Semestre::find($sem_id)->promotion;
        $this->module = Semestre::find($sem_id)->modules->where('id',$id)->first();
        $this->session = $session;
        $this->header_size = $this->module->getSessionDevoirsCount($session)+5;
        parent::__construct($this->promotion->formation->name,'Notes du Module '.$this->module->name,$this->header_size,15);
        $this->start_row = 15;
        $this->isEmpty = $empty;

    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->promotion->etudiants;
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
    public function headings(): array
    {
        $heads = ['Nom', 'Prénom', 'CIN', 'Date Naissance', 'Lieu Naissance'];
        foreach($this->module->devoirs as $devoir){
            if($devoir->session == $this->session){
                array_push($heads,$devoir->name);
            }
        }
        return $heads;
    }
    public function map($etudiant): array
    {
        $flag = 0;
        $row = [
            $etudiant->first_name,
            $etudiant->last_name,
            $etudiant->cin,
            $etudiant->born_date,
            $etudiant->cne,
        ];
        foreach ($this->module->devoirs as $devoir) {
            if($devoir->session == $this->session){
                $evaluation = $devoir->evaluations->where('etudiant_cin',$etudiant->cin)->first();
                if($evaluation){
                    $flag = 1 ;
                    if($this->isEmpty == "true"){
                        array_push($row,"0");
                    }else{
                        array_push($row,$evaluation->note?:0);
                    }
                }
            }
        }
        if($flag == 0 ){
            return [];
        }else{
            return $row;
        }
    }
    public function columnWidths(): array
    {
        $widths = [
            'A' => 20,
            'B' => 35,
            'C' => 19,
            'D' => 22,
            'E' => 30,

        ];
        for ($i = 0; $i < $this->header_size - 5; $i++) {
            $widths[chr(70 + $i)] = 15;
        }

        return $widths;
    }
    public function title():string{
        return $this->module->name;
    }
}

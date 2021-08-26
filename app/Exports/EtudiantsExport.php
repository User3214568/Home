<?php

namespace App\Exports;

use App\Etudiant;
use App\Formation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Excel;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EtudiantsExport implements FromQuery,WithTitle,WithMapping,WithStyles,WithColumnWidths,WithDrawings,WithStartRow,WithHeadings , WithCustomStartCell
{
    private $auto_incremental = 0;
    private $formation;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($id_formation = null){
        $this->formation = $id_formation;

    }

    public function query()
    {
        $etudiants = Etudiant::query()->with('formation');
        if(isset($this->formation)){
            $etudiants = $etudiants->where('formation_id',$this->formation);
        }
        return $etudiants;
    }
    public function startRow(): int
    {
        return 16;
    }
    public function startCell(): string
    {
        return 'B16';
    }
    public function headings() : array {
        return [
            'Numéro',
            'Code Massar',
            'Nom',
            'Prénom',
            'CIN',
            'Date Naissance',
            'Email'
        ];
    }
    public function map($etudiant):array{
        $this->auto_incremental++;
        return [
            $this->auto_incremental,
            $etudiant->cne,
            $etudiant->first_name,
            $etudiant->last_name,
            $etudiant->cin,
            $etudiant->born_date,
            $etudiant->email
        ];
    }

    public function drawings()
    {
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(storage_path('templates/header.png'));
        $drawing->setHeight(140);
        $drawing->setCoordinates('A2');
        return [$drawing];
    }
    public function title():string{

        if(isset($this->formation)) {
            $formation =  Formation::find($this->formation);
            if($formation != null) return $formation->name;
        }
        return "Feuille";
    }
    public function styles(Worksheet $sheet)
    {
        if(isset($this->formation)){

            $sheet->getCell('B11')->setValue('Formation');
            $sheet->getCell('C11')->setValue(Formation::find($this->formation)->name);
            $sheet->getCell('B13')->setValue('Niveau');
            $sheet->getCell('C13')->setValue('Pas Encore');
        }
            $styles = [];
        $header = ['B','C','D','E','F','G','H'];
        for($i = 10 ; $i < 150 ; $i++){

            $styles[$i]['font']= ['size'=>13,'name'=>'arial'];
            if($i == 16){
                foreach ($header as  $value) {
                    $styles[$value."".$i]['fill'] =[
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => ['rgb' => 'ff4800']
                    ];
                    $styles[$value."".$i]['alignment'] = [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ];
                }
            }
            if(isset($this->formation) && ($i == 11 || $i ==13)){
                $styles["B".$i]['fill'] =[
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['rgb' => 'ff4800']
                ];
                $styles["C".$i]['fill'] =[
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['rgb' => '0b77bf']
                ];

            }
            if($i<=16)
            $styles[$i]['font']['color'] = ['argb' => 'FFFFFF'];
            $styles[$i]['alignment'] = [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ];
        }
        return $styles;
    }
    public function columnWidths(): array
    {
        return [
            'A'=>5,
            'B'=> 20,
            'C'=> 20,
            'D'=> 20,
            'E'=> 20,
            'F'=> 20,
            'G'=> 20,
            'H'=> 20,
        ];
    }
}

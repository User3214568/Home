<?php

namespace App\Exports;

use App\Professeur;
use App\Teacher;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportProfesseur extends TemplateExport implements  FromArray,WithTitle, WithColumnWidths, WithHeadings, WithMapping,WithEvents
{
    public function __construct($formation, $empty = false)
    {
        $this->formation = $formation;
        $this->empty = $empty;
        $this->recettes = 0 ;
        $this->total = 0;
        $this->size_rows = 0;
        $this->header_size = $empty ? 3 : 5;
        $this->init();
        parent::__construct($formation->name, "Liste des Professeurs Affectés aux Modules",  $this->header_size);
    }
    public function additionalStyles(Worksheet $sheet, $styles)
    {
        for ($i = 0; $i < $this->size_rows; $i++) {
            for ($j = 0; $j < $this->header_size; $j++) {
                $styles[chr(65 + $j) . "" . ($i + 12)] = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                        ],
                    ],
                    'font'=>['size'=>13 ]
                ];
            }
        }

        if(!$this->empty){
            $sheet->getCell('B'.($this->size_rows+13))->setValue("Recettes");
            $sheet->getCell('C'.($this->size_rows+13))->setValue($this->recettes);
            $sheet->getCell('B'.($this->size_rows+14))->setValue("Restant");
            $sheet->getCell('C'.($this->size_rows+14))->setValue($this->total - $this->formation->getPaid());
            $styles['B'.($this->size_rows+13).':'.'C'.($this->size_rows+13)] = [
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                    ],
                ],
                'font'=>['size'=>13 ,'bold'=>true]

            ];
            $styles['B'.($this->size_rows+14).':'.'C'.($this->size_rows+14)] = [
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                    ],
                ],
                'font'=>['size'=>13,'bold'=>true ]

            ];
        }
        return $styles;
    }
    public function registerEvents(): array
    {
        if($this->empty){

            $this->values = "";
            $teachers = Teacher::all();
            $this->length = sizeof($teachers);
            foreach ($teachers as $key => $teacher) {
                $this->values .= $teacher->__toString();
                if(isset($teachers[$key+1])) $this->values .= " , ";
            }
            return [
                AfterSheet::class => function(AfterSheet $event){
                    for($i = 12 ; $i < 12 + $this->size_rows ; $i++){
                        $this->dropdown($event,"B",$i,$this->values,$this->length);
                    }
                }
            ];
        }else return [];
    }
    private function dropdown($event , $col ,$row,$values,$length){
        /** @var Sheet $sheet */
        $sheet = $event->sheet;

        /**
         * validation for bulkuploadsheet
         */
        $this->rowCount = 1;
        for( $i= $row; $i < $row + $this->rowCount; $i++){
            $sheet->setCellValue("$col".$i, $sheet->getCell("$col".$i)->getValue());
            $configs = "$values";
            $objValidation = $sheet->getCell("$col".$i)->getDataValidation();
            $objValidation->setType(DataValidation::TYPE_LIST);
            $objValidation->setErrorStyle(DataValidation::STYLE_STOP);
            $objValidation->setAllowBlank(false);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowErrorMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setErrorTitle('Donnée Invalide');
            $objValidation->setError('Vous devez choisir un professeur de la list.');
            $objValidation->setPromptTitle('Selectionner un Professeur');
            $objValidation->setPrompt('Merci de séléctionner un professeur de la list.');
            $objValidation->setFormula1('"' . $configs . '"');
        }
    }
    public function init(){
        $modules = [];
        foreach ($this->formation->semestres as $semestre) {
            foreach ($semestre->modules as  $module) {
                array_push($modules, $module);
            }
        }
        $this->size_rows = sizeof($modules);
        $this->modules = $modules;
    }
    public function array():array{

        return $this->modules;
    }
    public function headings(): array
    {
        $head = ['Module'];
        if($this->empty){
            array_push($head,'Informations du Professeur','Somme');
        }else{
            array_push($head,'Code  du Professeur',
            'Nom du Professeur',
            'Prénom du Professeur',
            'Somme');
        }
        return $head;
    }
    public function map($module): array
    {
        $row = [];
        if (!$this->empty) {
            $professeur = Professeur::get()->where('module_id', $module->id)->where('formation_id', $this->formation->id)->first();
            if($professeur){

                $this->total += $professeur->somme;
                $row = array_merge($row, [
                    $module->name,
                    $professeur->teacher->id,
                    $professeur->teacher->user->first_name,
                    $professeur->teacher->user->last_name,
                    $professeur->somme
                ]);
            }
        } else {
            $row = array_merge($row, [
                $module->name,
            ]);
        }
        return $row;
    }
    public function columnWidths(): array
    {
        $arr = [ 'A' => 35 , 'B' => 40 ];
        if($this->empty){
            $arr['C'] = 15;
        }
        else{
            $arr['C'] = 45;
            $arr['D'] = 45;
            $arr['E'] = 15;
        }
        return $arr;
    }
    public function title(): string
    {
        return $this->formation->name;
    }
}

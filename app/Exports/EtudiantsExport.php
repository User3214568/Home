<?php

namespace App\Exports;

use App\Etudiant;
use App\Formation;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EtudiantsExport Extends TemplateExport implements FromCollection,WithTitle,WithMapping,WithStyles,WithColumnWidths,WithHeadings
{
    private $auto_incremental = 0;
    private $formation;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($formation,$type){
        $this->formation = $formation;
        $this->type = $type;
        parent::__construct($formation->name,"Liste des Etudiants",8-($type?1:0));
    }
    public function additionalStyles(Worksheet $sheet, $styles)
    {
        return $styles;
    }
    public function collection()
    {
        if($this->type){
          return   new Collection();
        }
        return $this->formation->etudiants;

    }


    public function headings() : array {
        $array =  [
            'Nom',
            'Prénom',
            'CIN',
            'Date de Naissance',
            'Lieu de Naissance',
            'Téléphone',
            'Email'
        ];
        if(!$this->type){
            array_unshift($array,'Numéro');
        }
        return $array;
    }
    public function map($etudiant):array{
        $this->auto_incremental++;
        return [
            $this->auto_incremental,
            $etudiant->user->first_name,
            $etudiant->user->last_name,
            $etudiant->user->cin,
            $etudiant->born_date,
            $etudiant->born_place,
            $etudiant->user->phone,
            $etudiant->user->email,
        ];
    }


    public function title():string{
        return $this->formation->name;
    }

    public function columnWidths(): array
    {
        $array = [
            'A'=>20,
            'B'=> 20,
            'C'=> 20,
            'D'=> 20,
            'E'=> 20,
            'F'=> 20,
            'G'=> 20,

        ];
        if(!$this->type){
            $array['H'] = 20;
        }
        return $array;
    }
}

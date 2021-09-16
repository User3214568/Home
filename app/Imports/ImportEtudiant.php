<?php

namespace App\Imports;

use App\Etudiant;
use App\Exceptions\ImportException;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportEtudiant implements ToModel,WithHeadingRow,WithValidation
{
    public function __construct($formation)
    {
        $this->formation = $formation;
        $this->etudiants = [];
    }
    public function model(array $row)
    {
        try{

            $etudiant =   new Etudiant([
                'cin'=>$row['cin'],
                'first_name'=>$row['nom'],
                'last_name'=>$row['prenom'],
                'born_date'=>Date::excelToDateTimeObject($row['date_de_naissance'])->format('Y-m-d'),
                'born_place'=>$row['lieu_de_naissance'],
                'email'=>$row['email'],
                'phone'=>$row['telephone'],
                'formation_id'=>$this->formation->id
            ]);
            array_push($this->etudiants,$etudiant);
        }catch(Exception $e){
            throw new ImportException($e->getMessage());
        }
    }

    public function headingRow():int{
        return 11;
    }
    public function getEtudiants(){
        return $this->etudiants;
    }
    public function rules(): array
    {
        return [
            '*.cin'=>['required','unique:etudiants'],
            '*.nom'=>['required'],
            '*.date_de_naissance'=>['required','numeric'],
            '*.lieu_de_naissance'=>['required'],
            '*.email'=>['email','required'],
            '*.telephone'=>['required']
        ];
    }
}

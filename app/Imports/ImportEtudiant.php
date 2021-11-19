<?php

namespace App\Imports;

use App\Etudiant;
use App\Evaluation;
use App\Exceptions\ImportException;
use App\Promotion;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
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

        $promo = Promotion::premier($this->formation->id);
        if($promo instanceof Builder) throw new ImportException("Verifier que vous avez des Promotions dans la formation ".$this->formation->name);
        try{
            $etudiant =  Etudiant::rcreate([
                'cin'=>$row['cin'],
                'first_name'=>$row['nom'],
                'last_name'=>$row['prenom'],
                'born_date'=>Date::excelToDateTimeObject($row['date_de_naissance'])->format('Y-m-d'),
                'born_place'=>$row['lieu_de_naissance'],
                'email'=>$row['email'],
                'phone'=>$row['telephone'],
                'formation_id'=>$this->formation->id,
                'promotion_id'=>$promo->id
            ],$promo);

        }catch(QueryException $e){
            throw new ImportException($e->getMessage());
        }
        foreach ($promo->semestres as $semestre) {
            foreach ($semestre->modules as $module) {
                foreach ($module->devoirs as $devoir) {
                    if ($devoir->session == 1)
                        Evaluation::create(['devoir_id' => $devoir->id, 'etudiant_cin' => $etudiant->cin]);
                }
            }
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
            '*.cin'=>['required','unique:users,cin'],
            '*.nom'=>['required'],
            '*.date_de_naissance'=>['required','numeric'],
            '*.lieu_de_naissance'=>['required'],
            '*.email'=>['email','required','unique:users,email'],
            '*.telephone'=>['required']
        ];
    }
}

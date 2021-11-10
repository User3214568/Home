<?php

namespace App\Imports;

use App\Exceptions\ImportException;
use App\Module;
use App\Paiement;
use App\Professeur;
use App\Teacher;
use App\User;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportPaiementFormation implements ToModel,WithStartRow,WithValidation
{
    public function __construct($formation)
    {
        $this->formation = $formation;
        $this->count = 0 ;
        $this->date = null;
    }
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {

        if($this->count == 0 ){
            if($row[0] == "Date" && $row[2] !== null ){
                try{
                    $this->date = Date::excelToDateTimeObject($row[2])->format('Y-m-d');
                }catch(Exception $e){
                    throw new ImportException($e->getMessage());
                }
            }else{
                throw new ImportException("Vous avez tentez d'importer un fichier des paiement sans Saisir la Date.");
            }
        }elseif($this->count>1 && $this->date !== null && $row [0] !== null && $row [1] !== null && $row [2] != null){
            $user = User::find($row[0]);
            if($user){
                $teacher = $user->teacher;
                if($teacher){
                    try{
                        Paiement::create(['formation_id'=>$this->formation->id,'teacher_id'=>$teacher->id,'montant'=>$row[2],'date_payement'=>$this->date]);
                    }catch(Exception $e){
                        throw new ImportException($e->getMessage());
                    }
                }
            }

        }
        $this->count++;
    }
    public function startRow(): int
    {
        return 11;
    }
    public function rules(): array
    {
        return [

        ];
    }

}

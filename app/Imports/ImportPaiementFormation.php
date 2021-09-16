<?php

namespace App\Imports;

use App\Exceptions\ImportException;
use App\Module;
use App\Paiement;
use App\Professeur;
use App\Teacher;
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
            if($row[0] == "Date"){
                try{
                    $this->date = Date::excelToDateTimeObject($row[1])->format('Y-m-d');
                }catch(Exception $e){
                    dd($row[0]);die();
                    throw new ImportException($e->getMessage());
                }
            }
        }elseif($this->count>1){
            $teacher = Teacher::get()->where('name',$row[0])->first();
            if($teacher){
                if($row[0] != null && $row[1] != null){
                    Paiement::create(['formation_id'=>$this->formation->id,'teacher_id'=>$teacher->id,'montant'=>$row[1],'date_payement'=>$this->date]);
                }
                try{
                }catch(Exception $e){
                    throw new ImportException($e->message);
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

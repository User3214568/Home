<?php

namespace App\Imports;

use App\Module;
use App\Paiement;
use App\Professeur;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportPaiementFormation implements ToModel,WithStartRow
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
                    dd("FAILED");
                }
            }
        }elseif($this->count>1){
            $module = Module::get()->where('name',$row[0])->first();
            $professeur = Professeur::get()->where('name',$row[1])->where('module_id',$module->id)->first();
            if($module && $professeur){
                try{
                    Paiement::create(['formation_id'=>$this->formation->id,'professeur_id'=>$professeur->id,'montant'=>$row[2],'date_payement'=>$this->date]);
                }catch(Exception $e){
                    dd("FAILED");
                }
            }
        }
        $this->count++;
    }
    public function startRow(): int
    {
        return 11;
    }

}

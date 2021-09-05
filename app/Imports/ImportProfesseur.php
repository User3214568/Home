<?php

namespace App\Imports;

use App\Module;
use App\Professeur;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ImportProfesseur implements ToModel,WithHeadingRow
{
    public function __construct($formation)
    {
        $this->formation = $formation;
    }
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        $module_id = Module::get()->where('name',$row['module'])->first();

        if($module_id){
            $module_id = $module_id->id;
            if($row['nom_du_professeur'] != "" && $row['nom_du_professeur'] != null &&  $row['somme'] != ""){
                Professeur::create(['name'=>$row['nom_du_professeur'] ,
                'module_id'=>$module_id,
                'somme'=>$row['somme'],
                'formation_id'=>$this->formation->id]);
            }
        }
    }

    public function headingRow():int {
        return 11;
    }

}

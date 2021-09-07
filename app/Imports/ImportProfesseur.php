<?php

namespace App\Imports;

use App\Module;
use App\Professeur;
use App\Teacher;
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
            if($row['nom_du_professeur'] != "" && $row['nom_du_professeur'] != null &&  $row['somme'] != "" && $row['somme'] != null){
                $prof = Professeur::with('teacher')->get()->where('module_id',$module_id)->where('formation_id',$this->formation->id)->where('teacher.name',$row['nom_du_professeur'])->first();
                if($prof){
                    $prof->update(['somme'=>$row['somme']]);
                }else{
                    $teacher  = Teacher::get()->where('name',$row['nom_du_professeur'])->first();
                    if(!$teacher){
                        $teacher = Teacher::create(['name'=>$row['nom_du_professeur']]);
                    }
                    Professeur::create(['module_id'=>$module_id,
                    'somme'=>$row['somme'],
                    'formation_id'=>$this->formation->id,
                    'teacher_id'=>$teacher->id]);
                }
            }
        }
    }

    public function headingRow():int {
        return 11;
    }

}

<?php

namespace App\Utilities;

use App\Etudiant;

class Validation {

    public static function OrdinaireValidateModule($cin,$module_id,$result=true){
        return Validation::validateSessionModule($cin,$module_id,1,$result);
    }
    public static function RattValidateModule($cin,$module_id,$result=true){
        return Validation::validateSessionModule($cin,$module_id,2,$result);
    }

    public static function FinalModuleNote($cin,$module_id){
       $ord =  Validation::validateSessionModule($cin,$module_id,1,false);
       $note_validation =  Etudiant::find($cin)->formation->critere->note_validation;
       if($ord < $note_validation){
            $rat = Validation::validateSessionModule($cin,$module_id,2,false);
            return $rat>$note_validation?$note_validation:max($rat,$ord);
       }
       return $ord;
    }

    public static function validateSessionModule($cin,$module_id,$session,$result = true){
        $etudiant = Etudiant::find($cin);
        $critere = $etudiant->promotion->formation->critere;
        $average = 0 ;
        foreach ($etudiant->evaluations as $evaluation) {
            if($evaluation->devoir->session == $session){
                if($evaluation->devoir->module->id == $module_id){
                    $average += $evaluation->devoir->ratio  * $evaluation->note / 100;
                }
            }
        }
        if(!$result) return $average;
        if($average >= $critere->note_validation){

            return 'Validé';
        }
        else{
            if($average >= $critere->note_aj){
                return 'Non Validé';
            }
            else{
                return 'Ajourné';
            }
        }
    }
    public function calMoyenSemestre($cin,$sem_id){

    }
}

?>

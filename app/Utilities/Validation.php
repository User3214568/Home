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
            if($session == 1) return "Rattrappage";
            if($average >= $critere->note_aj){
                return 'Non Validé';
            }
            else{
                return 'Ajourné';
            }
        }
    }
    public static function result($cin){
        $count  = 0;
        $moy = 0;
        $nv = 0;
        $aj = 0;
        $e = Etudiant::find($cin);
        if($e){
            $note_validation = $e->formation->critere->note_validation;
            $note_aj  = $e->formation->critere->note_aj;
            foreach ($e->promotion->semestres as $semestre) {
                foreach ($semestre->modules as $module) {
                    $note  = Validation::FinalModuleNote($cin,$module->id);
                    $moy += $note;
                    $count++;
                    if($note < $note_validation){
                        if($note < $note_aj){
                            $aj++;
                        }else{
                            $nv++;
                        }
                    }
                }
            }
            if($count != 0) $moy/=$count;
            return ['note'=>number_format($moy,2),'nv'=>$nv,'aj'=>$aj,'final'=>Validation::decisionFinal($e,$e->formation,$nv,$aj)];
        }
    }
    public static function decisionFinal($etudiant,$formation,$nnv,$naj){
        if($etudiant && $formation){
            $num_aj = $formation->critere->number_aj;
            $num_nv = $formation->critere->number_nv;
            if($naj > $num_aj || $nnv > $num_nv){
                return 0;
            }
            else{
                return 1;
            }

        }
    }
}

?>

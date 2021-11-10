<?php

namespace App\Utilities;

use App\Etudiant;
use App\Professeur;

class Validation
{

    public static function OrdinaireValidateModule($cin, $module_id, $result = true)
    {
        return Validation::validateSessionModule($cin, $module_id, 1, $result);
    }
    public static function RattValidateModule($cin, $module_id, $result = true)
    {
        return Validation::validateSessionModule($cin, $module_id, 2, $result);
    }

    public static function FinalModuleNote($cin, $module_id)
    {
        $ord =  Validation::validateSessionModule($cin, $module_id, 1, false);
        $note_validation =  Etudiant::find($cin)->formation->critere->note_validation;
        if ($ord < $note_validation) {
            $rat = Validation::validateSessionModule($cin, $module_id, 2, false);
            return $rat > $note_validation ? $note_validation : max($rat, $ord);
        }
        return $ord;
    }

    public static function validateSessionModule($cin, $module_id, $session, $result = true, $flag = false)
    {
        $desc = "";
        $done = false;
        $etudiant = Etudiant::find($cin);
        $critere = $etudiant->promotion->formation->critere;
        $average = 0;
        foreach ($etudiant->evaluations as $evaluation) {
            if ($evaluation->devoir->session == $session) {
                if ($evaluation->devoir->module) {
                    if ($evaluation->devoir->module->id == $module_id) {
                        if(!$done) $done = true;
                        if($evaluation->note  === null){
                            if($flag) return ['note'=>'Pas Encor Mis','result'=>'Pas Encore'];
                            else{
                                if(!$result){
                                    return 0;
                                }
                                return 'Ajourné';
                            }
                        }
                        $average += $evaluation->devoir->ratio  * $evaluation->note / 100;
                    }
                }
            }
        }
        $desc =  Validation::resultDesc($etudiant->formation,$average,$session==1?1:0);
        if($flag){
            if(!$done){
                return ['note'=>'Pas Encor Mis','result'=>'Pas Encore'];
            }else{
                return ['note'=>$average , 'result'=>$desc];
            }
        }else{
            if($result){
                return $desc;
            }else{
                return $average;
            }
        }

    }
    public static function result($cin)
    {
        $count  = 0;
        $moy = 0;
        $nv = 0;
        $aj = 0;
        $e = Etudiant::find($cin);
        if ($e) {
            $note_validation = $e->formation->critere->note_validation;
            $note_aj  = $e->formation->critere->note_aj;
            foreach ($e->promotion->semestres as $semestre) {
                foreach ($semestre->modules as $module) {
                    $note  = Validation::FinalModuleNote($cin, $module->id);
                    $moy += $note;
                    $count++;
                    if ($note < $note_validation) {
                        if ($note < $note_aj) {
                            $aj++;
                        } else {
                            $nv++;
                        }
                    }
                }
            }
            if ($count != 0) $moy /= $count;
            return ['note' => number_format($moy, 2), 'nv' => $nv, 'aj' => $aj, 'final' => Validation::decisionFinal($e, $e->formation, $nv, $aj)];
        }
    }
    public static function decisionFinal($etudiant, $formation, $nnv, $naj)
    {
        if ($etudiant && $formation) {
            $num_aj = $formation->critere->number_aj;
            $num_nv = $formation->critere->number_nv;
            if ($naj > $num_aj || $nnv > $num_nv) {
                return 0;
            } else {
                return 1;
            }
        }
    }
    public static function resultDesc($formation, $note, $flag = 0)
    {
        $note_validation = $formation->critere->note_validation;

        if ($note >= $note_validation) {
            return "Validé";
        } else {
            $note_aj = $formation->critere->note_aj;
            if($flag === 1 ) return "Rattrappage";
            if($flag === 2) return 'Ajourné';
            if ($note >= $note_aj) {
                return "Non Validé";
            } else {
                return "Ajourrné";
            }
        }
    }
    public static function disableOld($m,$f){
        $profs = Professeur::moduleFormation($m,$f);
        foreach($profs as $prof){
            $prof->active = false;
            $prof->save();
        }
    }
}

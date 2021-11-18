<?php

namespace App;

use App\Scopes\EvaluationScope;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = ['note','etudiant_cin','devoir_id'];

    public function devoir(){
        return $this->belongsTo(Devoir::class);
    }
    public function etudiant(){
        return $this->belongsTo(Etudiant::class);
    }
    public function scopeEvaluationSession($query,$cin,$module_id,$session){
        $evals = $query->with('devoir')->where('etudiant_cin',$cin)->get();
        $evals = $evals->toArray();
        $c = 0 ;
        foreach($evals as $eval){
            $devoir = Devoir::find($eval['devoir_id']);
            if($devoir){
                if($devoir->module_id == $module_id){
                    if($devoir->session == $session) return true;
                }
            }

        }
        return false;
    }
    public function scopeSemestreSession($query,$cin,$sem_id,$session){

        $evals = $query->with('devoir')->where('etudiant_cin',$cin)->get();
        $evals = $evals->toArray();
        foreach($evals as $eval){
            $devoir = Devoir::find($eval['devoir_id']);
            if($devoir){
                if($devoir->session == $session){
                    if($devoir->module){
                        $sems = $devoir->module->semestres->where('id',$sem_id);
                        if(sizeof($sems) > 0){
                            return true;
                        }
                    }
                }
            }

        }
        return false;

    }
    public function scopeEEMS($query,$cin,$id,$session){
        $evals =  $query->with('devoir')->where('etudiant_cin',$cin)->where('devoir_id',$id)->get();
        $evals = $evals->toArray();

        foreach ($evals as $eval) {

            if($eval['devoir']['session'] == $session){

                return $eval['id'];
            }
        }

    }

    public function getModule(){
        $devoir = $this->devoir;
        return $devoir->module->id;
    }

}

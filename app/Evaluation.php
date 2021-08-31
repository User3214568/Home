<?php

namespace App;

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
    public function scopeEvaluationSession($query,$cin,$session){
        foreach($query->where('etudiant_cin',$cin)->get() as $v){
            $devoir = Devoir::find($v->devoir_id);
            if($devoir){
                if($devoir->session == $session) return true;
            }

        }
        return false;
    }
    public function getModule(){
        $devoir = $this->devoir;
        return $devoir->module->id;
    }
}

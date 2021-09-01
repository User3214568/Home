<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    protected $primaryKey='cin';
    public $incrementing  = false;

    protected $fillable = ['formation_id','first_name','last_name','cin','cne','born_date','email','promotion_id'];

    public function formation(){
        return $this->belongsTo(Formation::class);

    }

    public function promotion(){
        return $this->belongsTo(Promotion::class);
    }

    public function evaluations(){
        return $this->hasMany(Evaluation::class);
    }
    /**
     * Cette Function test si un etudiant donné à un rattrappage dans un module donné
     */
    public function hasSession($module_id,$session){
        return Evaluation::evaluationsession($this->cin,$module_id,$session);
    }
    /**
     * Cette Function test si un etudiant donné à un rattrappage dans une semestre donné
     */
    public function hasSessionSemestre($sem_id,$session){
        return Evaluation::Semestresession($this->cin,$sem_id,$session);
    }
    public function moduleAverage($id_module,$session){
        $evaluations = Etudiant::find($this->cin)->evaluations;
        $avg = 0;
        if( sizeof($evaluations) > 0 ){
            foreach ($evaluations as $evaluation) {
                if($evaluation->getModule() == $id_module){
                    if($evaluation->devoir->session == $session){
                        $avg+= $evaluation->note*$evaluation->devoir->ratio/100;
                    }
                }
            }
            return $avg;
        }else{
            return null;
        }
    }
}

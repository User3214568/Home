<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = ['name','description','index'];

    public function semestres(){
        return $this->belongsToMany(Semestre::class);
    }
    public function etudiants(){
        return $this->belongsToMany(Etudiant::class);
    }
    public function devoirs(){
        return $this->hasMany(Devoir::class);
    }
    public function professeur(){
        return $this->belongsToMany(Professeur::class);
    }
    public function getSessionDevoirsCount($session){
        $count = 0 ;
        foreach ($this->devoirs as $devoir) {
            if($devoir->session == $session){
                $count++;
            }
        }
        return $count;
    }
}

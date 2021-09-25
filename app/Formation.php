<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{

    protected $fillable = ['name','description','critere_id'];
    public $prix = 16000;
    public function semestres(){
        return $this->hasMany(Semestre::class)->orderBy('numero');
    }
    public function etudiants(){
        return $this->hasMany(Etudiant::class);
    }
    public function promotions(){
        return $this->hasMany(Promotion::class);
    }
    public function professeurs(){
        return $this->hasMany(Professeur::class);
    }
    public function paiements(){
        return $this->hasMany(Paiement::class);
    }

    public function teachers(){
        $teachers = [];
        foreach ($this->professeurs as  $prof) {
            if(!in_array($prof->teacher,$teachers)){

                $prof->teacher->name = $prof->teacher->user->first_name." ".$prof->teacher->user->last_name;
                array_push($teachers,$prof->teacher);
            }
        }
        return $teachers;
    }
    public function totalPaiements(){
        $total = 0 ;
        foreach ($this->professeurs as  $professeur) {
            $total += $professeur->somme;
        }
        return $total;
    }
    public function getPaiements(){
        $total = 0 ;
        foreach ($this->paiements as $paiement) {
            $total += $paiement->montant;
        }
        return $total;
    }
    public function getVersement(){
        $total = 0;
        foreach ($this->etudiants as $etudiant) {
            $total += $etudiant->totalVersements();
        }
        return $total;
    }
    public function getPaid(){
        $total = 0;
            foreach ($this->paiements as  $p) {
                $total += $p->montant;
            }
            return $total;

    }
    public function getEffectif(){
        $count = 0 ;
        foreach ($this->semestres   as $sem) {
            $count += sizeof($sem->modules);
        }
        return $count;
    }
    public function scopeName($query,$name){
        return $query->where('name' , $name);
    }
    public function critere(){
        return $this->belongsTo(Critere::class);
    }
}

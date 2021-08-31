<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{

    protected $fillable = ['name','description','critere_id'];


    public function semestres(){
        return $this->hasMany(Semestre::class)->orderBy('numero');
    }
    public function etudiants(){
        return $this->hasMany(Etudiant::class);
    }
    public function promotions(){
        return $this->hasMany(Promotion::class);
    }
    public function scopeName($query,$name){
        return $query->where('name' , $name);
    }
    public function critere(){
        return $this->hasOne(Critere::class);
    }
}

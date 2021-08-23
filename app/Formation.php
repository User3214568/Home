<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{

    protected $fillable = ['name','description'];


    public function semestres(){
        return $this->hasMany(Semestre::class);
    }
    public function etudiants(){
        return $this->hasMany(Etudiant::class);
    }
    public function scopeName($query,$name){
        return $query->where('name' , $name);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable  = ['numero','nom','formation_id'];

    public function formation(){
        return $this->belongsTo(Formation::class);
    }
    public function etudiants(){
        return $this->hasMany(Etudiant::class);
    }
    public function semestres(){
        return $this->hasMany(Semestre::class);
    }
    public function scopePremier($query,$formation){
        return $query->where('formation_id',$formation)->where('numero',1);
    }
    public function scopeDeuxieme($query,$formation){
        return $query->where('formation_id',$formation)->where('numero',2);
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{

    protected $fillable = ['name','description'];

    public function modules(){
        return $this->belongsToMany(Module::class);
    }
    public function etudiants(){
        return $this->hasMany(Etudiant::class);
    }
}

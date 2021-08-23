<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = ['name','description','index'];

    public function semestres(){
        return $this->belongsToMany(Semestre::class);
    }
}

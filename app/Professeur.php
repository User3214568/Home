<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Professeur extends Model
{
    protected $fillable = ['name','somme','module_id','teacher_id','formation_id'];
    public function formation(){
        return $this->belongsTo(Formation::class);
    }
    public function module(){
        return $this->belongsTo(Module::class);
    }
    public function paiements(){
        return $this->hasMany(Paiement::class);
    }
    public function teacher(){
        return $this->belongsTo(Teacher::class);
    }

}

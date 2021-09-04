<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Professeur extends Model
{
    protected $fillable = ['name','somme','module_id','formation_id'];
    public function formation(){
        return $this->belongsTo(Formation::class);
    }
    public function module(){
        return $this->belongsTo(Module::class);
    }
}

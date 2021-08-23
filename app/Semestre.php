<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Semestre extends Model
{
    protected $fillable = ['numero','formation_id'];

    public function modules(){
        return $this->belongsToMany(Module::class);
    }
    public function formation(){
        return $this->belongsTo(Formation::class);
    }
}

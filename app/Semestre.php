<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Semestre extends Model
{
    protected $fillable = ['numero','formation_id','promotion_id'];

    public function modules(){
        return $this->belongsToMany(Module::class);
    }
    public function formation(){
        return $this->belongsTo(Formation::class);
    }
    public function promotion(){
        return $this->belongsTo(Promotion::class);
    }
    public function scopeNumero($query,$formation,$numero){
        return $query->where('formation_id',$numero)->where('numero',$numero)[0];
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Devoir extends Model
{
    protected $fillable = ['name','ratio','note','module_id'];
    public function module(){
        return $this->belongsTo(Module::class);
    }
    public function evaluations(){
        return $this->hasMany(Evaluation::class);
    }

}

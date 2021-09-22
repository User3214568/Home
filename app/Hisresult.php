<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hisresult extends Model
{
    protected $fillable = ['semestre','module_id','history_id','note_final'];
    public function module(){
        return $this->belongsTo(Module::class);
    }
    public function history(){
        return $this->belongsTo(History::class);
    }
}

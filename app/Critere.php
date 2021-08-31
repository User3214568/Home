<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Critere extends Model
{
    protected $fillable = ['note_validation', 'note_aj','number_aj','number_nv'];
    public function formation(){
        return $this->belongsTo(Formation::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = ['note','etudiant_cin','devoir_id'];

    public function devoir(){
        return $this->belongsTo(Devoir::class);
    }
    public function etudiant(){
        return $this->belongsTo(Etudiant::class);
    }

}

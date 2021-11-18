<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tranche extends Model
{
    protected $fillable = ['vers','date_vers','proved','ref','etudiant_cin'];
    public function etudiant(){
        return $this->belongsTo(Etudiant::class);
    }
}

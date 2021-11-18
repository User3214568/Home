<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Graduated extends Model
{
    protected $fillable = ['au','formation_id','etudiant_cin'];

    public function formation(){
        return $this->belongsTo(Formation::class);
    }
    public function etudiant(){
        return $this->belongsTo(Etudiant::class);
    }

}

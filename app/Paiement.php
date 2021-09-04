<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $fillable = ['professeur_id','date_payement','montant','formation_id'];
    public function formation(){
        return $this->belongsTo(Formation::class);
    }
    public function professeur(){
        return $this->belongsTo(Professeur::class);
    }
}

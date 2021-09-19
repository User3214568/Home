<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = ['id','first_name','last_name'];
    public  $incrementing = false;
    public function paiements(){
        return $this->hasMany(Paiement::class);
    }
    public function sommes(){
        return $this->belongsToMany(Professeur::class);
    }
    public function getPaiement(){
        $total = 0 ;
        foreach ($this->paiements as $paiement) {
            $total += $paiement->montant;
        }
        return $total;
    }
    public function __toString()
    {
        return "$this->id : $this->first_name $this->last_name";
    }
}

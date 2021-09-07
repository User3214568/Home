<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $fillable = ['teacher_id','date_payement','montant','formation_id'];
    public function formation(){
        return $this->belongsTo(Formation::class);
    }
    public function teacher(){
        return $this->belongsTo(Teacher::class);
    }

}

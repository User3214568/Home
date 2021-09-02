<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $fillable = ['prof','date_payement','montant','module_id','formation_id'];
}

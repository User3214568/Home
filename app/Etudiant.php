<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    protected $primaryKey='cin';
    public $incrementing  = false;

    protected $fillable = ['formation_id','first_name','last_name','cin','cne','born_date','email','promotion_id'];

    public function formation(){
        return $this->belongsTo(Formation::class);

    }
    public function promotion(){
        return $this->belongsTo(Promotion::class);
    }
    public function modules(){
        return $this->belongsToMany(Module::class);
    }

}

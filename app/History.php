<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $fillable = ['etudiant_cin','promotion_id','au','result'];
    public function etudiant(){
        return $this->belongsTo(Etudiant::class);
    }
    public function promotion(){
        return $this->belongsTo(Promotion::class);
    }
    public function hisresults(){
        return $this->hasMany(Hisresult::class);
    }
    public function getModules(){
        $modules=  [];
        foreach ($this->hisresults as $hresult) {
            if(!in_array($hresult->module,$modules)){
                array_push($modules,$hresult->module);
            }
        }
        return $modules;
    }


}

<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = ['user_cin'];
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
        if($this->user){

            return $this->user_cin.":". $this->user->first_name .":". $this->user->last_name;
        }
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function professeurs(){
        return $this->hasMany(Professeur::class);
    }
    public function authModules(){
        $res = $this->professeurs->sortBy('created_at')->groupBy(['formation_id','module_id']);
        $auth_formations = [];
        foreach($res as $formation => $modules){
            $auth_formations[$formation]= [];
            foreach ($modules as $module => $profs) {
                $current_prof = Professeur::where('module_id',$module)->get()->sortBy('created_at')->first();
                if($current_prof->teacher_id == $this->id){
                    array_push($auth_formations[$formation],$module);
                }
            }
        }
        return $auth_formations;
    }

}

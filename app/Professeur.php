<?php

namespace App;

use App\Scopes\GraduatedScope;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\ProfesseurScope;

class Professeur extends Model
{
    protected $fillable = ['somme','module_id','teacher_id','formation_id'];
    public function formation(){
        return $this->belongsTo(Formation::class);
    }
    public function module(){
        return $this->belongsTo(Module::class);
    }
    public function paiements(){
        return $this->hasMany(Paiement::class);
    }
    public function teacher(){
        return $this->belongsTo(Teacher::class);
    }
    public function scopeModuleFormation($query,$m,$f){
        return $query->where('module_id',$m)->where('formation_id',$f)->get();
    }
    public function findPromotion(){
        $promo = $this->module->semestres->where('formation_id',$this->formation_id)->first()->promotion;
        return $promo;
    }
    public static function booted(){
        static::addGlobalScope(new ProfesseurScope);
    }
}

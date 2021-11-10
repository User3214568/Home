<?php

namespace App;

use App\Scopes\GraduatedScope;

use Illuminate\Database\Eloquent\Model;

class Etudiant extends User
{
    protected $primaryKey='cin';
    protected $fillable = ['formation_id','user_cin','born_date','born_place','promotion_id'];
    public $incrementing = true;


    public function formation(){
        return $this->promotion->formation();
    }
    public function graduations(){
        return $this->hasMany(Graduated::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function promotion(){
        return $this->belongsTo(Promotion::class);
    }

    public function evaluations(){
        return $this->hasMany(Evaluation::class);
    }
    public function tranches(){
        return $this->hasMany(Tranche::class);
    }
    public function histories(){
        return $this->hasMany(History::class);
    }
    public function totalVersements(){
        $total = 0 ;
        foreach ($this->tranches as $tranche) {
            $total += $tranche->vers;
        }
        return $total;
    }
    /**
     * Cette Function test si un etudiant donné à un rattrappage dans un module donné
     */
    public function hasSession($module_id,$session){
        return Evaluation::evaluationsession($this->cin,$module_id,$session);
    }
    /**
     * Cette Function test si un etudiant donné à un rattrappage dans une semestre donné
     */
    public function hasSessionSemestre($sem_id,$session){
        return Evaluation::Semestresession($this->cin,$sem_id,$session);
    }
    public function moduleAverage($id_module,$session){
        $evaluations = Etudiant::find($this->cin)->evaluations;
        $avg = 0;
        if( sizeof($evaluations) > 0 ){
            foreach ($evaluations as $evaluation) {
                if($evaluation->getModule() == $id_module){
                    if($evaluation->devoir->session == $session){
                        $avg+= $evaluation->note*$evaluation->devoir->ratio/100;
                    }
                }
            }
            return $avg;
        }else{
            return null;
        }
    }
    public static function booted(){
        static::addGlobalScope(new GraduatedScope);
    }

    public static function rcreate(array $arr,$promo){
        $user = User::create(['first_name'=>$arr['first_name'], 'last_name'=>$arr['last_name'], 'cin'=>$arr['cin'] , 'email'=>$arr['email'],'phone'=>$arr['phone'],'password'=>bcrypt(strtoupper($arr['first_name'])."@".strtoupper($arr['last_name'])),'type'=>2]);
        $etudiant = Etudiant::create([ 'born_date' =>$arr['born_date'], 'born_place'=>$arr['born_place'], 'promotion_id' => $promo->id,'user_cin'=>$arr['cin']]);
        return $etudiant;
    }

}

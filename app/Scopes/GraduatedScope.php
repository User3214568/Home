<?php
namespace App\Scopes;

use App\Etudiant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class GraduatedScope implements Scope  {
    public function __construct()
    {
        $this->filtered = Etudiant::withoutGlobalScope(GraduatedScope::class)->get()->filter(function($etudiant){
            $formation_id = $etudiant->formation_id;
            if($etudiant->graduations->contains('formation_id',$formation_id)){
                return false;
            }else{

                return true;
            }
        });

    }

    public function apply(Builder $builder , Model $model){

        $builder->withoutGlobalScope(GraduatedScope::class)->get()->where('cin','IN',$this->filtered->pluck('cin'));
    }

}

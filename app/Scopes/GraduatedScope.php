<?php
namespace App\Scopes;

use App\Etudiant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class GraduatedScope implements Scope  {

    public function apply(Builder $builder , Model $model){
        $grads = Etudiant::withoutGlobalScope(GraduatedScope::class)->get()->filter(function($etudiant){
            $grad = $etudiant->graduations->where('formation_id',$etudiant->formation->id);
            return !($grad  && sizeof($etudiant->graduations) > 0) ;
        });
        if(Auth::user()->type == 2){
            $builder->withoutGlobalScope(GraduatedScope::class);
        }else{
            $builder->withoutGlobalScope(GraduatedScope::class)->whereIn('cin',$grads->pluck('cin'));
        }
    }

}

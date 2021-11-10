<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$type)
    {

        if(strval(Auth::user()->type) == $type){
            return $next($request);
        }else{
            if(Auth::user()->type == 1){
                return redirect('/enseignant');
            }
            if(Auth::user()->type == 2){
                return redirect('/etudiant');
            }
            return redirect('/');
        }

    }

}

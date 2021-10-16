<?php

namespace App\Http\Middleware;

use App\Evaluation;
use Closure;
use Illuminate\Support\Facades\Auth;

class AccessLimitations
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user()->type == 0){
            return $next($request);
        }
        else{
            if(preg_match('/user\/?$/',$request->route()->uri())){
                return redirect(route('user.edit',['user'=>Auth::user()->cin]));
            }

            if($this->treatURL($request,Auth::user()->teacher->authModules())){
                return $next($request);
            }else{

                $error = "Vous n'avez pas d'acces à ces ressources";
                return response()->view('parts.admin.common.error',compact(['error']));
            }
        }
    }
    private function treatURL($request,$auth_modules){
        if(preg_match('/request-notes/',$request->route()->uri())){
            return $this->inArray($request->route('module'),$auth_modules) || $request->route('module') === 'all';
        }

        if(preg_match('/commit/',$request->route()->uri())){
            return $this->inArray($request->route('module_id'),$auth_modules);
        }
        if(preg_match('/update-note/',$request->route()->uri())){
            return $this->updateNotesFilter($request,$auth_modules);
        }
        if(preg_match('/import-module-note/',$request->route()->uri())){
            return $this->inArray($request->route('module_id'),$auth_modules);
        }
        if(preg_match('/export-module-notes/',$request->route()->uri())){
            return $this->inArray($request->route('module_id'),$auth_modules);
        }

        return true;
    }
    private function inArray($needle , $array){
        foreach ($array as $key => $value) {
            if(in_array($needle,$value)){
                return true;
            }
        }
        return false;
    }
    private function updateNotesFilter($request,$auth_modules){
        if(isset($request->evaluations)){
            $evaluations = json_decode($request->evaluations, true);
            foreach ($evaluations as $key => $note) {
                $eval = Evaluation::find($key);
                return $this->inArray($eval->devoir->module_id,$auth_modules);
            }
        }
    }
}

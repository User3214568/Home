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
            $cin = Auth::user()->cin;
            if(preg_match('/logout/',$request->route()->uri(),$matched)){
                return $next($request);
            }

            if(preg_match('/^users\/avatars\/{cin}/',$request->route()->uri(),$matched)){
                if($request->route('cin') === $cin){
                    return $next($request);
                }else{
                    return response("Error : Unauthorized",400);
                }
            }

            if(preg_match('/admin\/user\/{user}\/edit/',$request->route()->uri())){
                    return $next($request);
            }
            if(preg_match('/admin\/user(\/{user})?\/?$/',$request->route()->uri())){
                if($request->method() === 'PUT'){
                    return $next($request);
                }
            }
            if(Auth::user()->type === 1){
                $check = $this->treatURL($request,Auth::user()->teacher->authModules());
                if($check){
                    return $next($request);
                }else{
                    $error = "Désolé. Vous n'etes pas autorisé d'acceder à ces ressources.";
                    if(preg_match('/update-note/',$request->route()->uri()) && $check === null){
                        $error = "Désolé. Il n'existe aucune note à modifier";
                    }
                    if($request->ajax){
                        return response(['message'=>$error],400);
                    }else{
                        return response()->view('parts.admin.common.error',compact(['error']));
                    }
                }
            }else{

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

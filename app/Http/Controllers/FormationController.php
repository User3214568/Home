<?php

namespace App\Http\Controllers;

use App\Formation;
use App\Module;
use App\Semestre;
use Illuminate\Http\Request;

class FormationController extends Controller
{
    public function index(){
        return view('');
    }

    public function create(){
        $content = 'formation.create';
        $modules = Module::get();
        $semestres = Semestre::with('modules')->get();
        return view('admin',compact(['content','semestres','modules']));
    }
    public function store(Request $request){

        $isvalid = $request->validate([
            'name'=>'required|unique:modules|max:255',
            'description'=>'required'
        ]);
        if($isvalid){
            $semestres = json_decode($request->semestres,true);
            $formation = Formation::create($request->only(['name','description']));
            foreach($semestres as $semestre => $modules){
                $create_sem = $id = Semestre::create(['numero'=>$semestre , 'formation_id'=>$formation->id]);
                $create_sem->modules()->sync($modules);
            }
            return redirect(route('formation.create'));
        }
        else{

        }
    }
    public function edit($id){
        $content = 'formation.update';
        $formation = Formation::with('semestres')->find($id);
        if( $formation->semestres != null){
            $formation->semestres->ids = [];
            foreach($formation->semestres as $semestre){
                $modules_id = [];
                foreach($semestre->modules as $module){
                    array_push($modules_id,$module->id);
                }
                $formation->semestres->ids[$semestre->numero] = $modules_id;
            }
        }

        $modules = Module::get();
        $semestres = Semestre::with('modules')->get();
        return view('admin',compact(['content','semestres','modules','formation']));
    }
}

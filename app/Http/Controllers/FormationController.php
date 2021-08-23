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
            return redirect('formation.create');
        }
        else{

        }
    }

}

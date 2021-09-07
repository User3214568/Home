<?php

namespace App\Http\Controllers;

use App\Formation;
use App\Professeur;
use App\Teacher;
use Illuminate\Http\Request;

class ProfesseurController extends Controller
{
    public function index(){
        $content = "list-prof";
        $formations = Formation::get();
        $allprofs = Professeur::with('formation')
        ->get()
        ->groupBy('formation.name');
        return view('admin',compact(['profs','content','formations','allprofs']));
    }
    public function create(){
        $content = "professeur.create";
        $formations = Formation::get();
        return view('admin',compact(['content','formations']));
    }
    public function store(Request $request){
        $request->validate([
            'name'=>'required|max:255',
            'module_id'=>'required|numeric',
            'formation_id'=>'required|numeric',
            'somme'=>'required|numeric'
        ]);
        $teacher = Teacher::get()->where('name',$request->name)->first();
        if(!$teacher){
            $teacher = Teacher::create(['name'=>$request->name]);
        }
        Professeur::create(array_merge($request->only(['module_id','formation_id','somme']),['teacher_id'=>$teacher->id]));
        return $this->index();
    }
    public function edit($id){
        $content = "professeur.update";
        $formations = Formation::get();
        $prof = Professeur::find($id);
        if($prof){
            return view('admin',compact(['prof','content','formations']));
        }
    }
    public function update($id, Request $request){
        $request->validate([
            'name'=>'required|max:255',
            'module_id'=>'numeric',
            'formation_id'=>'required|numeric',
            'somme'=>'required|numeric'
        ]);
        $prof = Professeur::find($id);
        if($prof){
            $teacher = Teacher::get()->where('name',$request->name)->first();
            if(!$teacher){
                $teacher = Teacher::create(['name'=>$request->name]);
            }
            $prof->update(array_merge($request->only(['module_id','formation_id','somme']),['teacher_id'=>$teacher->id]));
        }
        return $this->index();
    }
    public function destroy($id){
        Professeur::destroy($id);
        return $this->index();
    }
}

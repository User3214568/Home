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
        $teachers = Teacher::get();
        return view('admin',compact(['content','teachers','formations']));
    }
    public function store(Request $request){
        $request->validate([
            'teacher_id'=>'required',
            'module_id'=>'required|numeric',
            'formation_id'=>'required|numeric',
            'somme'=>'required|numeric'
        ]);
        Professeur::create($request->all());
        return redirect(route('professeur.index'));
    }
    public function edit($id){
        $content = "professeur.update";
        $formations = Formation::get();
        $prof = Professeur::find($id);
        $teachers = Teacher::get();
        if($prof){
            return view('admin',compact(['prof','teachers','content','formations']));
        }
    }
    public function update($id, Request $request){
        $request->validate([
            'teacher_id'=>'required',
            'module_id'=>'required|numeric',
            'formation_id'=>'required|numeric',
            'somme'=>'required|numeric'
        ]);
        $prof = Professeur::find($id);
        if($prof){
            $prof->update($request->all());
        }
        return redirect(route('professeur.index'));
    }
    public function destroy($id){
        Professeur::destroy($id);
        return redirect(route('professeur.index'));
    }
}

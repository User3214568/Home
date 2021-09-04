<?php

namespace App\Http\Controllers;

use App\Formation;
use App\Professeur;
use Illuminate\Http\Request;

class ProfesseurController extends Controller
{
    public function index(){
        $content = "list-prof";
        $formations = Formation::get();
        $profs = Professeur::get();
        return view('admin',compact(['profs','content','formations']));
    }
    public function create(){
        $content = "professeur.create";
        $formations = Formation::get();
        return view('admin',compact(['content','formations']));
    }
    public function store(Request $request){
        $request->validate([
            'name'=>'required|unique:professeurs|max:255',
            'module_id'=>'required|numeric',
            'formation_id'=>'required|numeric',
            'somme'=>'required|numeric'
        ]);
        Professeur::create($request->all());
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
            $prof->update($request->all());
        }
        return $this->index();
    }
    public function destroy($id){
        Professeur::destroy($id);
        return $this->index();
    }
}

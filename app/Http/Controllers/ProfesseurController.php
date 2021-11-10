<?php

namespace App\Http\Controllers;

use App\Formation;
use App\Professeur;
use App\Scopes\ProfesseurScope;
use App\Teacher;
use App\Utilities\Validation;
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
        Validation::disableOld($request->module_id,$request->formation_id);
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
        Validation::disableOld($request->module_id,$request->formation_id);
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
    public function history(){
        $content = "history-prof";
        $formations = Formation::get();
        $allprofs = Professeur::withoutGlobalScope(ProfesseurScope::class)->with('formation')
        ->get()
        ->groupBy('formation.name')->sortBy('created_at');
        return view('admin',compact(['content','formations','allprofs']));
    }
}

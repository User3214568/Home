<?php

namespace App\Http\Controllers;

use App\Etudiant;
use App\Formation;
use App\Promotion;
use Illuminate\Http\Request;

class EtudiantController extends Controller
{
    public function index(){
        $content = 'etudiant.index';
        $formations = Formation::get();
        $etudiants = Etudiant::get();
        return view('admin',compact(['formations','content','etudiants']));
    }
    public function create(){
        $content = 'etudiant.create';
        $formations = Formation::get();
        return view('admin',compact(['content','formations']));
    }
    public function store( Request $request){
        $is_valid = $request->validate([
            'first_name'=>'required|max:50',
            'last_name'=>'required|max:50',
            'cin'=>'required|unique:etudiants|max:15',
            'cne'=>'required|unique:etudiants|max:15',
            'email'=>'required|max:30',
            'formation_id'=>'required',
            'born_date'=>'required'

        ]);

        if($is_valid){
            $promo = Promotion::premier($request->formation_id)->get()[0];
            $etudiant = Etudiant::create(array_merge($request->only(['first_name','last_name','cin','cne','email','formation_id','born_date']),['promotion_id'=>$promo->id]));
            foreach($promo->semestres as $semestre){
                $etudiant->modules()->attach($semestre->modules);
            }
        }

        if(!isset($request->ajax)) return $this->index();

    }
    public function edit($id){
        $etudiant = Etudiant::find($id);
        $formations = Formation::get();
        $content = 'etudiant.update';
        return view('admin',compact(['etudiant','content','formations']));
    }
    public function update($id , Request $request){
        $is_valid = $request->validate([
            'first_name'=>'required|max:50',
            'last_name'=>'required|max:50',
            'cin'=>'required|max:15',
            'cne'=>'required|max:15',
            'email'=>'required|max:30',
            'formation_id'=>'required',
            'born_date'=>'required'

        ]);
        if($is_valid){

            $promo = Promotion::premier($request->formation_id)->get()[0];
            $etudiant = Etudiant::find($id);
            $etudiant->update($request->only(['first_name','last_name','cin','cne','email','formation_id','born_date']));
            foreach($promo->semestres as $semestre){
                $etudiant->modules()->sync($semestre->modules);
            }
        }
        return $this->index();
    }
    public function show($id){
        return Etudiant::find($id);
    }
    public function destroy($id){
        Etudiant::destroy($id);
        return $this->index();
    }
    public function evaluation(){
        $content ="etudiant.evaluation";
        $formations = Formation::get();
        return view('admin',compact(['content','formations']));
    }

}


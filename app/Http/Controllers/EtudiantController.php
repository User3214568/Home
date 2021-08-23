<?php

namespace App\Http\Controllers;

use App\Etudiant;
use App\Formation;
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
            'first_name'=>'required |max:50',
            'last_name'=>'required |max:50',
            'cin'=>'required|unique:Etudiants|max:15',
            'cne'=>'required|unique:Etudiants|max:15',
            'email'=>'required|max:30',
            'formation_id'=>'required',
            'born_date'=>'required'
        ]);
        if($is_valid){
            Etudiant::create($request->only(['first_name','last_name','cin','cne','email','formation_id','born_date']));
        }
        return redirect('etudiant/create');

    }
    public function edit($id){
        $etudiant = Etudiant::find($id);
        $formations = Formation::get();
        $content = 'etudiant.update';
        return view('admin',compact(['etudiant','content','formations']));
    }
    public function update($id , Request $request){
        Etudiant::find($id)->update($request->only(['first_name','last_name','cin','cne','email','formation_id','born_date']));
        return $this->edit($id);
    }
}

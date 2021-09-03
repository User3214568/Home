<?php

namespace App\Http\Controllers;

use App\Etudiant;
use App\Formation;
use App\Tranche;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TrancheController extends Controller
{

    public function index(){
        $etudiants = Etudiant::orderBy('formation_id','ASC')->get();
        $formations = Formation::get();
        $content = "finance.versemnt.list";
        return view('admin',compact(['content','etudiants','formations']));
    }
    public function create(){
        $content = "finance.add.tranche";
        $etudiants = Etudiant::get();
        return view('admin',compact(['content','etudiants']));
    }
    public function store(Request $request){
        $request->validate([
            'etudiant_cin'=>'required|max:10',
            'vers'=>'required|numeric',
            'date_vers'=>'required|date',
            'ref'=>'required'
        ]);

        Tranche::create(array_merge($request->only(['etudiant_cin','date_vers','vers','ref']),['proved'=>isset($request['proved'])]));
        return $this->addTranche();
    }
    public function edit($id){
        $tranche = Tranche::find($id);
        $content = 'finance.tranche.edit';
        return view('admin',compact(['content','tranche']));
    }
    public function update($id,Request $request){
        $tranche = Tranche::find($id);
        if($tranche){
            $tranche->update(array_merge($request->only(['etudiant_cin','date_vers','vers','ref']),['proved'=>isset($request['proved'])]));
        }
        return Redirect::route('tranche.index');
    }
    public function destroy($id){
        Tranche::destroy($id);
        return Redirect::route('tranche.index');
    }

}

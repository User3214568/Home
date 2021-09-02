<?php

namespace App\Http\Controllers;

use App\Etudiant;
use App\Formation;
use App\Paiement;
use App\Tranche;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function addTranche(){
        $content = "finance.add.tranche";
        $etudiants = Etudiant::get();
        return view('admin',compact(['content','etudiants']));
    }
    public function addPayement(){
        $formations = Formation::get();
        $content = "finance.add.payement";
        return view("admin",compact(['content','formations']));
    }
    public function payementConsultants(){
        $content = "finance.payement.consultants";
        $formations = Formation::get();
        return view("admin",compact(['content','formations']));
    }

    public function addTranchePost(Request $request){
        $request->validate([
            'etudiant_cin'=>'required|max:10',
            'vers'=>'required|numeric',
            'date_vers'=>'required|date',
            'ref'=>'required'
        ]);

        Tranche::create(array_merge($request->only(['etudiant_cin','date_vers','vers','ref']),['proved'=>isset($request['proved'])]));
        return $this->addTranche();
    }
    public function storePayement(Request $request){
       $request->validate([
        'module'=>'required|numeric',
        'prof'=>'string|max:255',
        'montant'=>'numeric',
        'date_payement'=>'date'
       ]);
       Paiement::create(array_merge($request->only(['prof','date_payement','montant']),['module_id'=>$request->module,'formation_id'=>$request->formation]));
       return $this->addPayement();
    }
}

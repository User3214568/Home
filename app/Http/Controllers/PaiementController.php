<?php

namespace App\Http\Controllers;

use App\Formation;
use App\Paiement;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    public function create(){
        $formations = Formation::get();
        $content = "finance.add.payement";
        return view("admin",compact(['content','formations']));
    }
    public function index(){
        $content = "finance.payement.consultants";
        $formations = Formation::get();
        return view("admin",compact(['content','formations']));
    }
    public function store(Request $request){
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

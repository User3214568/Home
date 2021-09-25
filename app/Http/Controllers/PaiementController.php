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
        'formation_id'=>'required|numeric',
        'module_id'=>'required',
        'montant'=>'required|numeric',
        'date_payement'=>'required|date'
       ]);
       Paiement::create(array_merge($request->only(['formation_id','date_payement','montant']),['teacher_id'=>$request->module_id]));
       return redirect(route('paiement.index'));
    }
    public function edit($id){
        $formations = Formation::get();
        $paiement = Paiement::find($id);
        if($paiement){
            $content = "finance.payement.update";
            return view("admin",compact(['content','formations','paiement']));
        }else{
            return $this->index();
        }
    }
    public function update($id ,Request $request){
        $request->validate([
            'formation_id'=>'required|numeric',
            'module_id'=>'required',
            'montant'=>'required|numeric',
            'date_payement'=>'required|date'
        ]);
        $paiement = Paiement::find($id);
        if($paiement){
            $paiement->update(array_merge($request->only(['formation_id','date_payement','montant']),['teacher_id'=>$request->module_id]));
        }
        return redirect(route('paiement.index'));

    }
    public function destroy($id){
        Paiement::destroy($id);
        return redirect(route('paiement.index'));

    }
}

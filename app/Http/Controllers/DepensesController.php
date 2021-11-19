<?php

namespace App\Http\Controllers;

use App\Depenses;
use App\Formation;
use Illuminate\Http\Request;

class DepensesController extends Controller
{
    public function index(){
        $content ="depense.list";
        $motifs = Depenses::get();
        $total = 0 ; //Just Counter used inside view;
        $total_eff = 0;
        $formations_effectifs = [];
        foreach (Formation::get() as $formation) {
            $formations_effectifs[$formation->name] = $formation->getEffectif();
            $total_eff+= $formations_effectifs[$formation->name];
        }
        $formations_effectifs = json_encode($formations_effectifs);
        return view('admin',compact(['content','motifs','total','total_eff','formations_effectifs']));
    }
    public function create(){
        $content = "depense.add";
        return view('admin',compact(['content']));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'name'=>'required|max:256',
            'somme'=>'required|numeric'
        ]);
        if($validated){
            Depenses::create($request->all());
        }
        return $this->index();
    }

    public function edit($id){
        $content = "depense.add";
        $dep = Depenses::find($id);
        return view('admin',compact(['content','dep']));
    }

    public function update($id,Request $request){
        $validated = $request->validate([
            'name'=>'required|max:256',
            'somme'=>'required|numeric'
        ]);
        if($validated){
            $dep = Depenses::find($id);
            if($dep){
                $dep->update($request->all());
            }
        }
        return $this->index();
    }
    public function destroy($id){
        Depenses::destroy($id);
        return $this->index();
    }
    public function getDeps(){
        $formations = Formation::get();
        $motifs  = Depenses::get();
        $total = 0 ;
        $total_effectif = 0 ;
        foreach ($formations as $formation) {
            $total_effectif += $formation->getEffectif();
        }
        return view('parts.admin.common.depense.dep-view-excel',compact(['formations','motifs','total','total_effectif']));
    }
}

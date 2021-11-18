<?php

namespace App\Http\Controllers;

use App\Etudiant;
use App\History;
use App\Scopes\GraduatedScope;

class HistoryController extends Controller
{
    public function index(){
        $content = "old.index";
        $formations = History::with('etudiant','promotion.formation')->get()->groupBy(['promotion.formation.name','au','promotion.nom']);
        foreach ($formations as $formation => $aus) {
            foreach ($aus as $au => $promos) {
                foreach ($promos as $promo => $histories) {
                    foreach ($histories as  $history) {
                        $history->etudiant = Etudiant::withoutGlobalScope(GraduatedScope::class)->find($history->etudiant_cin);
                    }
                }
            }
        }
        return view('admin',compact(['content','formations']));
    }
}

<?php

namespace App\Http\Controllers;

use App\History;

class HistoryController extends Controller
{
    public function index(){
        $content = "old.index";
        $formations = History::with('etudiant','promotion')->get()->groupBy(['etudiant.formation.name','au','promotion.nom']);
        return view('admin',compact(['content','formations']));
    }
}

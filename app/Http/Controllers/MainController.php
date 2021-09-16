<?php

namespace App\Http\Controllers;

use App\Depenses;
use App\Formation;

class MainController extends Controller
{
    public function index(){

        return view('index');
    }
    public function login(){
        return view('login');
    }
    public function restorePassword(){
        return view('pass-forg');
    }
    public function admin(){
        $content = "admin.home";

        $total_etudiants  = 0 ;
        $total_formations  = 0 ;
        $total_modules = 0 ;
        $total_profs = 0;
        $total_paiements = 0;
        $total_versments = 0;
        $total_avers = 0;
        $total_deps = 0;
        $stats = [];
        $fin_stats = [];
        foreach(Depenses::get() as $dep){
            $total_deps += $dep->somme;
        }
        foreach (Formation::get() as $formation) {
            $size_etudiant = sizeof($formation->etudiants);
            $size_profs = sizeof($formation->professeurs);
            $size_modules = $formation->getEffectif();
            $paiements = $formation->getPaiements();
            $f_total_paiements = $formation->totalPaiements();
            $total_paiements += $f_total_paiements;
            $stats[$formation->name] = [
                'etudiants'=>$size_etudiant,
                'modules' => $size_modules,
                'profs'=> $size_profs
            ];
            $f_total_versements = $formation->getVersement();
            $total_versments += $f_total_versements;
            $fin_stats[$formation->name] = [
                'total_vers'=>$size_etudiant*$formation->prix,
                'vers'=>$f_total_versements,
                'total_paiements' => $f_total_paiements,
                'paiements'=> $paiements
            ];
            $total_modules += $size_modules;
            $total_etudiants += $size_etudiant;
            $total_formations++;
        }
        return view('admin',compact(['content','total_deps','fin_stats','total_versments','total_paiements','total_profs','total_modules','total_versment','stats','total_formations','total_etudiants']));
    }

}

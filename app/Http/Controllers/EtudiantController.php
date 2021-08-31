<?php

namespace App\Http\Controllers;

use App\Etudiant;
use App\Evaluation;
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
                foreach($semestre->modules as $module){
                    foreach($module->devoirs as $devoir){
                        if($devoir->session == 1)
                        Evaluation::create(['devoir_id'=>$devoir->id,'etudiant_cin'=>$etudiant->cin]);
                    }
                }
            }
        }

        if(!isset($request->ajax)) return $this->index();

    }
    public function edit($id){
        $etudiant = Etudiant::find($id);
        $formations = Formation::get();
        $promotions = Formation::find($etudiant->formation_id)->promotions;
        $content = 'etudiant.update';
        return view('admin',compact(['etudiant','content','formations','promotions']));
    }
    public function update($id , Request $request){
        $is_valid = $request->validate([
            'first_name'=>'required|max:50',
            'last_name'=>'required|max:50',
            'cin'=>'required|max:15',
            'cne'=>'required|max:15',
            'email'=>'required|max:30',
            'formation_id'=>'required',
            'promotion_id'=>'required',
            'born_date'=>'required'

        ]);
        if($is_valid){
            $promo = Promotion::premier($request->formation_id)->get()[0];
            $etudiant = Etudiant::find($id);
            $old_promo = $etudiant->promotion_id;
            $old_formation = $etudiant->formation_id;

            $etudiant->update($request->only(['first_name','last_name','cin','cne','email','formation_id','born_date','promotion_id']));
            if(!($old_formation == $request->formation_id && $old_promo == $request->promotion_id)){

                foreach ($etudiant->evaluations as  $evaluation) {
                    Evaluation::destroy($evaluation->id);
                }
                $promo = Promotion::find($request->promotion_id);
                foreach($promo->semestres as $semestre){
                    foreach($semestre->modules as $module){
                        foreach($module->devoirs as $devoir){
                            Evaluation::create(['devoir_id'=>$devoir->id,'etudiant_cin'=>$id]);
                        }
                    }

                }
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
    public function notesUpdate(Request $request ){
        if(isset($request->evaluations)){
            $evaluations = json_decode($request->evaluations,true);
            $fails = [];
            foreach($evaluations as $key => $note){
                $note = $note['note'];
                $note = trim($note);
                $eval = Evaluation::find($key);
                if(isset($eval)){
                    if(preg_match('/^[0-9]+(\.[0-9]+)?$/',$note) && $note >=0 && $note <= 20 ){
                        $eval->update(['note'=>$note]);
                    }
                    else{
                        array_push($fails,$note);
                    }
                }
                else array_push($fails,'Evaluation n\'a pas été trouvé');
            }
            if(sizeof($fails)==0){
                return response("Success");
            }else{
                return response(json_encode(['message'=>'Valeur non valide','content'=>$fails]));
            }
        }
        else{
            return "Data Invalides";
        }
    }
    public function results(){
        $content = 'etudiant.result';
        $formations = Formation::get();
        return view('admin',compact(['content','formations']));
    }


}


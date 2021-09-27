<?php

namespace App\Http\Controllers;

use App\Etudiant;
use App\Evaluation;
use App\Exceptions\CustomException;
use App\Formation;
use App\Hisresult;
use App\History;
use App\Module;
use App\Promotion;
use App\Semestre;
use App\Utilities\Validation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EtudiantController extends Controller
{
    public function index()
    {
        $content = 'etudiant.index';
        $formations = Formation::get();
        $etudiants = Etudiant::get();
        return view('admin', compact(['formations', 'content', 'etudiants']));
    }
    public function create()
    {
        $content = 'etudiant.create';
        $formations = Formation::get();
        return view('admin', compact(['content', 'formations']));
    }
    public function store(Request $request)
    {
        $is_valid = $request->validate([
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'cin' => 'required|unique:etudiants,cin|max:15',
            'email' => 'required|max:30',
            'formation_id' => 'required',
            'born_date' => 'required',
            'born_place' => 'required',
            'phone' => 'required'
        ]);

        if ($is_valid) {
            if (isset($request->promotion_id)) {
                $promo = $request->promotion_id;
            } else {
                $promo = Promotion::premier($request->formation_id);
            }
            $etudiant = Etudiant::create(array_merge($request->only(['first_name', 'last_name', 'cin', 'cne', 'email', 'formation_id', 'born_date', 'born_place', 'phone']), ['promotion_id' => $promo->id]));
            foreach ($promo->semestres as $semestre) {
                foreach ($semestre->modules as $module) {
                    foreach ($module->devoirs as $devoir) {
                        if ($devoir->session == 1)
                            Evaluation::create(['devoir_id' => $devoir->id, 'etudiant_cin' => $etudiant->cin]);
                    }
                }
            }
        }

        if (!isset($request->ajax)) return $this->index();
    }
    public function edit($id)
    {
        $etudiant = Etudiant::find($id);
        $formations = Formation::get();
        $promotions = Formation::find($etudiant->formation_id)->promotions;
        $content = 'etudiant.update';
        return view('admin', compact(['etudiant', 'content', 'formations', 'promotions']));
    }
    public function update($id, Request $request)
    {
        $is_valid = $request->validate([
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'cin' => 'required|max:15',
            'email' => 'required|max:30',
            'formation_id' => 'required',
            'promotion_id' => 'required',
            'born_date' => 'required',
            'born_place' => 'required',
            'phone' => 'required'
        ]);
        if ($is_valid) {
            $formation = Formation::find($request->formation_id);
            try {
                if ($formation) {
                    $promo = Promotion::premier($request->formation_id);
                }
                else throw new CustomException("La Formation demandé n'est pas existante");
            } catch (Exception $e) {
                throw new CustomException("Verifier Bien que la formation $formation->name a bien des des semestres enregistrées");
            }
            $etudiant = Etudiant::find($id);
            if(!$etudiant) throw new CustomException("L'Etudiant objectif de cette modification n'existe pas !");
            $old_promo = $etudiant->promotion_id;
            $old_formation = $etudiant->formation_id;

            $etudiant->update($request->only(['first_name', 'last_name', 'cin', 'cne', 'email', 'born_place', 'phone', 'formation_id', 'born_date', 'promotion_id']));
            if (!($old_formation == $request->formation_id && $old_promo == $request->promotion_id)) {
                foreach ($etudiant->evaluations as  $evaluation) {
                    Evaluation::destroy($evaluation->id);
                }
                $promo = Promotion::find($request->promotion_id);
                foreach ($promo->semestres as $semestre) {
                    foreach ($semestre->modules as $module) {
                        foreach ($module->devoirs as $devoir) {
                            if($devoir->session == 1){
                                Evaluation::create(['devoir_id' => $devoir->id, 'etudiant_cin' => $id]);
                            }
                        }
                    }
                }
            }
        }
        if (isset($request->ajax)) {
            return response("success");
        }
        return $this->index();
    }
    public function show($id)
    {
        return Etudiant::find($id);
    }
    public function destroy($id)
    {
        Etudiant::destroy($id);
        return $this->index();
    }
    public function evaluation()
    {
        $content = "etudiant.evaluation";
        $formations = Formation::get();
        return view('admin', compact(['content', 'formations']));
    }
    public function notesUpdate(Request $request)
    {
        if (isset($request->evaluations)) {
            $evaluations = json_decode($request->evaluations, true);
            $fails = [];
            foreach ($evaluations as $key => $note) {
                $note = $note['note'];
                $note = trim($note);
                $eval = Evaluation::find($key);
                if (isset($eval)) {
                    if (preg_match('/^[0-9]+(\.[0-9]+)?$/', $note) && $note >= 0 && $note <= 20) {
                        $eval->update(['note' => $note]);
                    } else {
                        array_push($fails, $note);
                    }
                } else array_push($fails, 'Evaluation n\'a pas été trouvé');
            }
            if (sizeof($fails) == 0) {
                return response("Success");
            } else {
                return response(json_encode(['message' => 'Valeur non valide', 'content' => $fails]));
            }
        } else {
            return "Data Invalides";
        }
    }
    public function results()
    {
        $content = 'etudiant.result';
        $formations = Formation::get();
        return view('admin', compact(['content', 'formations']));
    }
    public function delibration(){
        $content = "etudiant.delibration";
        $formations = Formation::get();
        return view('admin',compact(['content','formations']));
    }
    public function requestNotes($result,$promotion,$semestre,$module,$session){
        if(Auth::user()->type == 1){
            $f = Promotion::find($promotion)->formation;
            $auth_modules = Auth::user()->teacher->authModules()[$f->id];

        }
        if($result === "false"){
            $sem = Semestre::find($semestre);
            if($module === "all"){
                if(isset($auth_modules)){
                    return view('parts.admin.etudiant.tablenote',compact(['session','auth_modules','sem']));
                }else{
                    return view('parts.admin.etudiant.tablenote',compact(['session','sem']));
                }
            }else{
                $mymodule = Module::find($module);
                return view("parts.admin.etudiant.table-module-note",compact(['sem','mymodule','session']));

            }
        }else{
            $sem = Semestre::find($semestre);
            if($module === "all"){
                return view('parts.admin.etudiant.semestre-result',compact(['session','sem']));
            }else{
                $mymodule = Module::find($module);
                return view("parts.admin.etudiant.result-table",compact(['sem','mymodule','session']));

            }
        }
    }
    public function finAnnee(Request $request){
        if($request->results){
            $results = json_decode($request->results,true);
            foreach($results as $promo=>$etudiants){
                $promotion =   Promotion::find($promo);
                if($promotion){
                    $next_promo = $promotion->formation->promotions->where('numero',$promotion->numero+1)->first();
                    foreach ($promotion->etudiants as $etudiant) {
                        $history = History::create(['etudiant_cin'=>$etudiant->cin,
                                                    'promotion_id'=>$promotion->id,'au'=>(date('Y')-1)."-".date('Y')]);
                        foreach($promotion->semestres as $semestre){
                            foreach($semestre->modules as $module){
                                Hisresult::create(['module_id'=>$module->id,
                                    'history_id'=>$history->id,
                                    'semestre'=>$semestre->numero,
                                    'note_final'=> Validation::FinalModuleNote($etudiant->cin,$module->id)
                                ]);

                            }
                        }



                    }
                    foreach ($etudiants as  $e_res) {
                        $etudiant  = Etudiant::find($e_res['e']);
                        if($e_res['r'] == 0 && $etudiant && $next_promo){
                            $etudiant->promotion()->dissociate($promotion->id);
                            $etudiant->promotion()->associate($next_promo->id);
                            $etudiant->save();
                            foreach ($etudiant->evaluations as $evaluation) {
                                $evaluation->delete();
                            }
                            foreach($next_promo->semestres as $sem){
                                foreach ($sem->modules as  $mod) {
                                    foreach($mod->devoirs as $dev){
                                        Evaluation::create(['devoir_id'=>$dev->id,'etudiant_cin' => $e_res['e']]);
                                    }
                                }
                            }
                        }elseif($etudiant && $e_res['r'] == 1 && $promotion){
                            foreach ($etudiant->evaluations as $evaluation) {
                                if($evaluation->devoir->session == 2){
                                    $evaluation->delete();
                                }
                                $evaluation->update(['note'=>null]);
                            }
                        }
                    }


                }

            }

        }
        return redirect(route('etudiant.index'));
    }

}

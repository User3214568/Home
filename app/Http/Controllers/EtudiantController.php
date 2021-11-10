<?php

namespace App\Http\Controllers;

use App\Etudiant;
use App\Evaluation;
use App\Exceptions\CustomException;
use App\Formation;
use App\Graduated;
use App\Hisresult;
use App\History;
use App\Module;
use App\Promotion;
use App\Semestre;

use App\Utilities\Notificator;
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
            'cin' => 'required|unique:users,cin|max:15',
            'email' => 'required|email|unique:users,email|max:100',
            'formation_id' => 'required|numeric',
            'born_date' => 'required|date',
            'born_place' => 'required',
            'phone' => 'required'
        ]);

        if ($is_valid) {

                $formation = Formation::find($request->formation_id);
                if(!$formation) throw new CustomException("La fonction dans laquelle vous essayez enregistrer l'etudiant est inexistante");
                if(sizeof($formation->promotions)< 1) throw new CustomException("Vous devez avoir au moins une promotion dans cette formation");
                if (isset($request->promotion_id)) {
                    $promo = $request->promotion_id;
                } else {
                    $promo = Promotion::premier($request->formation_id);
                }
                if($promo){
                    $etudiant = Etudiant::rcreate($request->all(),$promo);
                    foreach ($promo->semestres as $semestre) {
                        foreach ($semestre->modules as $module) {
                            foreach ($module->devoirs as $devoir) {
                                if ($devoir->session == 1)
                                Evaluation::create(['devoir_id' => $devoir->id, 'etudiant_cin' => $etudiant->cin]);
                            }
                        }
                    }
                }

        }

        return redirect(route('etudiant.index'));
    }
    public function edit($id)
    {
        $etudiant = Etudiant::find($id);
        if($etudiant){
            $formations = Formation::get();
            $promotions = Formation::find($etudiant->formation->id)->promotions;
            $content = 'etudiant.update';
            return view('admin', compact(['etudiant', 'content', 'formations', 'promotions']));
        }
    }
    public function update($id, Request $request)
    {
        $is_valid = $request->validate([
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => 'required|email|max:100',
            'formation_id' => 'required|numeric',
            'promotion_id' => 'required|numeric',
            'born_date' => 'required|date',
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
            $old_formation = $etudiant->formation->id;

            $etudiant->user->update($request->only(['first_name', 'last_name', 'email', 'phone']));
            $etudiant->update($request->only(['born_place', 'born_date', 'promotion_id']));
            if (!($old_formation === $request->formation_id && $old_promo === $request->promotion_id)) {
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

        return redirect(route('etudiant.index'));
    }
    public function show($id)
    {
        return Etudiant::find($id);
    }
    public function destroy($id)
    {
        $etudiant = Etudiant::find($id);
        if($etudiant){
            foreach ($etudiant->evaluations as $evaluation) {
                $evaluation->delete();
            }
        }
        Etudiant::destroy($id);

        return redirect(route('etudiant.index'));
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
                return response()->json(['message'=>'Les Notes ont été bien Modifiées']);
            } else {
                return response(json_encode(['message' => 'Valeur non valide', 'content' => $fails]));
            }
        } else {
            return response(400)->json(['message'=>'La mise a jour a été echoué. Votre ']);
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
    private function saveHistories($promotion){
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
    }
    private function transitEtudiant($etudiants,$promotion,$next_promo){
        foreach ($etudiants as  $e_res) {
            $etudiant  = Etudiant::find($e_res['e']);
            $history = $etudiant->histories->where('promotion_id',$promotion->id)->where('au',(date('Y')-1)."-".date('Y'))->first();
            $history->result = $e_res['r'] == 0 ? 'Admis':'Ajourné';
            $history->save();
            if($e_res['r'] == 0 && $etudiant){
                $etudiant->promotion()->dissociate($promotion->id);
                if($next_promo){
                    $etudiant->promotion()->associate($next_promo->id);
                    foreach($next_promo->semestres as $sem){
                        foreach ($sem->modules as  $mod) {
                            foreach($mod->devoirs as $dev){
                                Evaluation::create(['devoir_id'=>$dev->id,'etudiant_cin' => $e_res['e']]);
                            }
                        }
                    }
                }else{
                    // Assign etudiant to graduateds
                    $etudiant->promotion_id = 0 ;
                    Graduated::create(['au'=>(date('Y')-1)."-".date('Y'),'formation_id'=>$etudiant->formation->id,'etudiant_cin'=>$etudiant->cin]);
                }
                $etudiant->save();
                foreach ($etudiant->evaluations as $evaluation) {
                    $evaluation->delete();
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
    public function finAnnee(Request $request){
        $notif = [];
        if($request->results){
            $results = json_decode($request->results,true);
            foreach($results as $promo=>$etudiants){
                $his = History::where('au',(date('Y')-1)."-".date('Y'))->where('promotion_id',$promo)->get();
                if(sizeof($his)>0) continue;
                $promotion =   Promotion::find($promo);
                if($promotion){
                    $next_promo = $promotion->formation->promotions->where('numero',$promotion->numero+1)->first();
                    $this->saveHistories($promotion);
                    $this->transitEtudiant($etudiants,$promotion,$next_promo);
                    array_push($notif,$promotion);
                }

            }

        }
        if($notif) {
            $notificator = new Notificator();

            $message = "L'utilisateur ".Auth::user()->name()." a fait la délibration des résultat des promotion";
            foreach ($notif as  $promo) {
                $message += " ".$promo->nom;
            }
            $notificator->notificate($message);
        }
        return redirect(route('etudiant.index'));
    }
    public function homepage(){
        $content = 'parts.etudiant.home';
        $etudiant = Auth::user()->etudiant;
        $histories = $etudiant->histories->sortBy('au');
        return view('etudiant',compact(['content','histories']));
    }
    public function resultsPage(){
        $content = ('parts.etudiant.results');
        $etudiant = Auth::user()->etudiant;
        $modules_results  = [];
        foreach ($etudiant->promotion->semestres as $sem) {
            foreach ($sem->modules as $module) {
                $results = [];
                for($session = 1 ; $session <= 2 ; $session++){
                    $results[$session] = Validation::validateSessionModule($etudiant->cin,$module->id,$session,false,true);
                }
                $modules_results[] = array('name'=>$module->name,'result'=>$results);
            }
        }
        return view('etudiant',compact(['content','modules_results']));
    }
    public function versements(){
        $content = 'parts.etudiant.versements';
        $versements = Auth::user()->etudiant->tranches;
        $etudiant = Auth::user()->etudiant;
        return view('etudiant',compact(['content','versements','etudiant']));
    }

}

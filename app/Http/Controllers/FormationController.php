<?php

namespace App\Http\Controllers;

use App\Critere;
use App\Etudiant;
use App\Evaluation;
use App\Formation;
use App\Module;
use App\Promotion;
use App\Semestre;
use Illuminate\Http\Request;

class FormationController extends Controller
{
    public function index()
    {
        $content = 'formation.index';
        $formations = Formation::get();
        return view('admin', compact(['formations', 'content']));
    }

    public function create()
    {
        $content = 'formation.create';
        $modules = Module::get();
        $semestres = Semestre::with('modules')->get();
        return view('admin', compact(['content', 'semestres', 'modules']));
    }
    public function store(Request $request)
    {

        $isvalid = $request->validate([
            'name' => 'required|unique:formations|max:255',
            'description' => 'required',
            'note_validation' => 'required|numeric',
            'note_aj' => 'required|numeric',
            'prix' =>  'required|numeric',
            'number_aj' => 'required|numeric',
            'number_nv' => 'required|numeric'
        ]);
        if ($isvalid) {
            $semestres = json_decode($request->semestres, true);

            $critere = Critere::create($request->only(['note_validation', 'note_aj', 'number_aj', 'number_nv']));
            $formation = Formation::create(array_merge($request->only(['name', 'description']), ['critere_id' => $critere->id]));
            if (sizeof($semestres) > 0) {
                foreach ($semestres as $semestre => $modules) {
                    if ($semestre % 2 != 0) {
                        $promo = Promotion::create(['numero' => (1 + (($semestre - 1) / 2)), 'nom' => (1 + (($semestre - 1) / 2)) . "" . ((1 + (($semestre - 1) / 2) == 1) ? 'ére' : 'ème') . ' Année', 'formation_id' => $formation->id]);
                    }
                    $create_sem  = Semestre::create(['numero' => $semestre, 'formation_id' => $formation->id, 'promotion_id' => $promo->id]);
                    $create_sem->modules()->attach($modules);
                }
            }


        }
        return redirect(route('formation.index'));
    }
    public function edit($id)
    {
        $content = 'formation.update';
        $formation = Formation::with('semestres')->find($id);
        if ($formation->semestres != null) {
            $formation->semestres->ids = [];
            foreach ($formation->semestres as $semestre) {
                $modules_id = [];
                foreach ($semestre->modules as $module) {
                    array_push($modules_id, strval($module->id));
                }
                $formation->semestres->ids[$semestre->numero] = $modules_id;
            }
        }
        $formation->semestres->ids['last'] = 1;
        $modules = Module::get();
        return view('admin', compact(['content', 'modules', 'formation']));
    }

    private function syncFormationSemestres($formation,$promo,$semestres){
        foreach ($semestres as $semestre => $modules) {
            if ($semestre !== 0) {
                $sem = $formation->semestres->where('numero', $semestre)->first();
                if ($sem) {
                    $sem->modules()->sync($modules);
                    foreach ($modules as $m) {
                        if (!in_array($m, $sem->modules->pluck('id')->toArray())) {
                            $my_mod = Module::find();
                            foreach ($sem->promotion->etudiants as $etudiant) {
                                foreach ($my_mod->devoirs as $dev) {
                                    Evaluation::create(['devoir_id' => $dev->id, 'etudiant_cin' => $etudiant->cin]);
                                }
                            }
                        }
                    }
                } else {

                    $my_sem  = Semestre::create(['numero' => $semestre, 'formation_id' => $formation->id, 'promotion_id' => $promo->id]);
                    $my_sem->modules()->attach($modules);
                    if (($semestre % 2 == 0) && isset($semestres[($semestre + 1) . ''])) {
                        $promo = Promotion::create(['numero' => (1 + (($semestre) / 2)), 'nom' => (1 + (($semestre) / 2)) . 'ére Année', 'formation_id' => $formation->id]);
                    }
                }
            }
        }
        foreach ($formation->semestres as  $f_sem) {
            if (!array_key_exists($f_sem->numero, $semestres)) {
                $f_sem->delete();
                if (!(sizeof($f_sem->promotion->semestres) > 0)) {
                    $f_sem->promotion->delete();
                }
            }
        }
    }

    public function update($id, Request $request)
    {

        $isvalid = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'prix' => 'required|numeric',
            'note_validation' => 'required|numeric',
            'note_aj' => 'required|numeric',
            'number_aj' => 'required|numeric',
            'number_nv' => 'required|numeric'
        ]);
        if ($isvalid) {
            $semestres = json_decode($request->semestres, true);
            $formation = Formation::with('semestres')->find($id);
            if($formation){

                $formation->update($request->only(['name', 'description']));
                Critere::find($formation->critere_id)->update($request->only(['note_validation', 'note_aj', 'number_aj', 'number_nv']));
                # find out if semestre already has some promotions
                if (!(sizeof($formation->promotions) > 0)) {
                    $promo = Promotion::create(['numero' => 1, 'nom' => '1ère Année', 'formation_id' => $id]);
                } else {
                    $promo = $formation->promotions->sortBy("numero")->last();
                    if ((sizeof($promo->semestres) == 2) && sizeof($semestres) > sizeof($formation->semestres)) {
                        $promo = Promotion::create(['numero' => ($promo->numero + 1), 'nom' => ($promo->numero + 1) . ((($promo->numero + 1) == 1) ? 'ére' : 'éme') . ' Année', 'formation_id' => $id]);
                    }
                }

                if (isset($semestres)) {
                    $this->syncFormationSemestres($formation,$promo,$semestres);
                }
            }
        }
        return redirect(route('formation.index'));
    }

    public function destroy($id)
    {
        $formation = Formation::with('semestres')->find($id);

        if ($formation) {

            foreach ($formation->promotions as $promo) {
                foreach ($promo->etudiants as  $etudiant) {
                    Etudiant::destroy($etudiant->cin);
                }
                Promotion::destroy($promo->id);
            }
            foreach ($formation->semestres as $sem) {
                Semestre::destroy($sem->id);
            }
        }
        Formation::destroy($id);
        if ($formation) Critere::destroy($formation->critere_id);
        return redirect(route('formation.index'));
    }
    public function notes(Request $request)
    {
        $result = $request->target;
        if (isset($request->id)) {
            $formation = Formation::find($request->id);
            return response(view('parts.admin.etudiant.tabnotes', compact(['formation', 'result'])), 200);
        } else {
            return response('Not Found', 404);
        }
    }

    public function getModules($id)
    {
        $formation = Formation::find($id);
        $modules = [];
        if ($formation) {
            foreach ($formation->semestres as   $s) {
                $modules  = array_merge($modules, $s->modules->toArray());
            }
        }
        return json_encode($modules);
    }
    public function getProfesseurs($id)
    {
        $formation = Formation::find($id);
        $profs = [];
        if ($formation) {
            $profs = $formation->teachers();
        }
        return json_encode($profs);
    }
    public function delibration($formation_id)
    {
        $formation = Formation::find($formation_id);
        if ($formation)
            return view('parts.admin.etudiant.delib-result', compact(['formation']));
    }
}

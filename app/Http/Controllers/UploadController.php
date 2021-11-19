<?php

namespace App\Http\Controllers;

use App\Etudiant;
use App\Exports\EtudiantsExport;
use App\Exports\ExportAllEtudiants;
use App\Exports\ExportAllFormationPaiement;
use App\Exports\ExportAllProfesseurs;
use App\Exports\ExportAllProfPaiement;
use App\Exports\ExportDepenses;
use App\Exports\ExportDepensesEmpty;
use App\Exports\ExportEmptyFormationPaiement;
use App\Exports\ExportFormationPaiement;
use App\Exports\ExportFormations;
use App\Exports\ExportPaiementProf;
use App\Exports\ExportProfesseur;
use App\Exports\ExportResultatModule;
use App\Exports\ExportTeachers;

use App\Exports\ExportVersementALL;
use App\Exports\FormationFinanceExport;
use App\Exports\FormationVersementsExport;
use App\Exports\ModuleExport;
use App\Exports\NotesExport;
use App\Formation;
use App\Imports\BulkImport;
use App\Imports\EtudiantImport;
use App\Imports\ImportDepenses;
use App\Imports\ImportEtudiant;
use App\Imports\ImportModule;
use App\Imports\ImportPaiementEtudiant;
use App\Imports\ImportPaiementFormation;
use App\Imports\ImportProfesseur;
use App\Imports\ImportTeachers;
use App\Module;
use App\Promotion;
use App\Semestre;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Excel as ExcelExcel;
use Maatwebsite\Excel\Facades\Excel;

use function PHPSTORM_META\type;

class UploadController extends Controller
{
    //
    public function importEtudiants($id,Request $request)
    {
        $etudiants = [];
        $f = Formation::find($id);
        if($f){
            $import = new ImportEtudiant($f);
            Excel::import($import,$request->file('file'));

        }
        return redirect(route('etudiant.index'));
    }
    public function exportEtudiants($id=0,$type=false)
    {
        if($type==="true") $type=true;
        else $type = false;
        if($id == 0 ){
            return Excel::download(new ExportAllEtudiants($type),"All_Etudiants_List_.xlsx");
        }
        else{
            $f = Formation::find($id);
            if($f){
                return Excel::download(new EtudiantsExport($f,$type),"Etudiants_List_".$f->name.".xlsx");
            }
        }
    }
    public function exportAllFormations()
    {
        return Excel::download(new ExportFormations(), 'etudiants.xlsx');
    }
    public function exportnotes($id)
    {
        if (is_numeric($id)) {
            return Excel::download(new NotesExport($id), 'notes.xlsx');
        } else {
            return redirect(route('etudiant.evaluation'));
        }
    }
    public function exportModule($sem_id, $module_id, $session, $type)
    {
        if (is_numeric($sem_id) && is_numeric($module_id) && is_numeric($session)) {
            $module = Module::find($module_id);
            $semestre = Semestre::find($sem_id);
            if($module && $semestre){
                return Excel::download(new ModuleExport($semestre, $module, $session, $type), 'module_'.$module->name.'_session_'.($session==1?'Ord_':'RATT_').date('d-m-y').'.xlsx');
            }
        }
    }
    public function importNoteModule($sem_id, $module_id, $session, Request $request)
    {
        $import_module =  new ImportModule($sem_id, $module_id, $session);
        $import_module->import($request->file('file'));
        if(Auth::user()->type == 0){
            return redirect(route('etudiant.evaluation'));
        }
        if(Auth::user()->type == 1){
            return redirect(route('enseignant.notes'));
        }

    }

    public function exportFinanceFormation($id, $type)
    {
        if ($id == 0) {
            return Excel::download(new ExportVersementALL(), "all-versement-" . date('d-m-Y') . ".xlsx");
        } else {

            $formation = Formation::find($id);
            if ($type == "true") $type = true;
            else $type = false;
            if ($formation) {
                return Excel::download(new FormationVersementsExport($formation, $type), "versement-" . $formation->name . ".xlsx");
            }
        }
    }
    public function importPaiementEtudiant(Request $request)
    {
        Excel::import(new ImportPaiementEtudiant(), $request->file('file'));
        return redirect(route('tranche.index'));
    }

    public function exportProfesseur($id,$type){
        if ($id == 0) {
            return Excel::download(new ExportAllProfesseurs(), "all_affectation_professeurs_" . date('d-m-Y') . ".xlsx");
        } else {

            $formation = Formation::find($id);
            if ($type == "true") $type = true;
            else $type = false;
            if ($formation) {
                return Excel::download(new ExportProfesseur($formation, $type), "affectation_professeurs_" . $formation->name . "-somme.xlsx");
            }
        }
    }

    function importProfesseurs($id, Request $request)
    {
        $formation = Formation::find($id);
        if ($formation) {
            Excel::import(new ImportProfesseur($formation), $request->file('file'));
        }
        return redirect(route('professeur.index'));
    }

    public function exportFormationPaiement($id,$type){

        if ($id == 0) {
            return Excel::download(new ExportAllFormationPaiement, "all_prof_list" . date('d-m-Y') . ".xlsx");
        } else {
            if ($type == "true") $type = true;
            else $type = false;
            $formation = Formation::find($id);
            if ($formation) {
                if($type){
                    return Excel::download(new ExportEmptyFormationPaiement($formation),"list_prof_empty_paiement" . $formation->name . ".xlsx");
                }else{
                    return Excel::download(new ExportFormationPaiement($formation, $type), "list_prof_paiement_" . $formation->name . ".xlsx");
                }
            }
        }
    }
    public function importProfPaiement($id , Request $request){
        $formation = Formation::find($id);

        if($formation){
            Excel::import(new ImportPaiementFormation($formation),$request->file('file'));
        }
        return redirect(route('paiement.index'));
    }

    public function importDepenses(Request $request){
        Excel::import(new ImportDepenses , $request->file('file'));
        $d =  new DepensesController;
        return $d->index();
    }
    public function exportDepenses($type){
        if($type == "true"){
            return Excel::download(new ExportDepensesEmpty,"vide_depenses_comunnes.xlsx");
        }else{
            return Excel::download(new ExportDepenses,"depenses_communes.xlsx");
        }
    }
    public function exportResultats($promotion_id,$session,$module_id){
        $module = Module::find($module_id);
        $promotion  = Promotion::find($promotion_id);
        if($module && $promotion && in_array($session,[1,2])){
            return Excel::download(new ExportResultatModule($promotion,$session,$module),"resultat_".$promotion->formation->name."_".$module->name."_session_".($session==1?"Ordinaire":"Ratt").".xlsx");
        }
    }

    public function exportTeachers($type){
        if($type==="true") $type=true;
        else $type = false;
        return Excel::download(new ExportTeachers($type),"list_".($type?'vide_':'')."professeurs.xlsx");
    }
    public function importTeachers(Request $request){
        Excel::import(new ImportTeachers(), $request->file('file'));
        return redirect(route('teacher.index'));
    }
}

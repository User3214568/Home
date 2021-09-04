<?php

namespace App\Http\Controllers;

use App\Etudiant;
use App\Exports\EtudiantsExport;
use App\Exports\ExportAllProfesseurs;
use App\Exports\ExportAllProfPaiement;
use App\Exports\ExportFormations;
use App\Exports\ExportPaiementProf;
use App\Exports\ExportProfesseur;
use App\Exports\ExportVersementALL;
use App\Exports\FormationFinanceExport;
use App\Exports\ModuleExport;
use App\Exports\NotesExport;
use App\Formation;
use App\Imports\BulkImport;
use App\Imports\ImportModule;
use App\Imports\ImportPaiementEtudiant;
use App\Imports\ImportProfesseur;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use function PHPSTORM_META\type;

class UploadController extends Controller
{
    //
    public function import(Request $request)
    {
        $bulk = new BulkImport;
        $etudiants = [];
        //$request->file('file')[0]->store('templates','public');
        foreach ($request->file('file') as $file) {
            $array = Excel::toArray($bulk, $file);
            $etudiants = array_merge($etudiants, $bulk->treat($array));
        }
        $content = 'etudiant.index';
        $import = true;
        $formations = Formation::get();
        return view('admin', compact(['formations', 'content', 'etudiants', 'import']));
    }
    public function export()
    {
        return Excel::download(new EtudiantsExport, 'etudiant.xlsx');
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
            return Excel::download(new ModuleExport($sem_id, $module_id, $session, $type), 'modules.xlsx');
        } else {
            return redirect(route('etudiant.evaluation'));
        }
    }
    public function importNoteModule($sem_id, $module_id, $session, Request $request)
    {
        $import_module =  new ImportModule($sem_id, $module_id, $session);
        $import_module->import($request->file('file'));

        return redirect(route('etudiant.evaluation'));
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
                return Excel::download(new FormationFinanceExport($formation, $type), "versement-" . $formation->name . ".xlsx");
            }
        }
    }
    public function importPaiementEtudiant(Request $request)
    {

        Excel::import(new ImportPaiementEtudiant(), $request->file('file'));
        return redirect(route('finance.versement.lis'));
    }

    public function exportProfPaiement($id)
    {
        if ($id == 0) {
            return Excel::download(new ExportAllProfPaiement(), "all_versement_" . date('d-m-Y') . ".xlsx");
        } else {
            $formation = Formation::find($id);
            if ($formation) {
                return Excel::download(new ExportPaiementProf($formation), "paiement_prof_" . $formation->name . ".xlsx");
            }
        }
    }
    public function exportProfesseur($id, $type)
    {
        if ($id == 0) {
            return Excel::download(new ExportAllProfesseurs, "all_prof_list" . date('d-m-Y') . ".xlsx");
        } else {
            if ($type == "true") $type = true;
            else $type = false;

            $formation = Formation::find($id);
            if ($formation) {
                return Excel::download(new ExportProfesseur($formation, $type), "list_prof_" . $formation->name . ".xlsx");
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
}

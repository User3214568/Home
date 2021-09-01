<?php

namespace App\Http\Controllers;

use App\Etudiant;
use App\Exports\EtudiantsExport;
use App\Exports\ExportFormations;
use App\Exports\ModuleExport;
use App\Exports\NotesExport;
use App\Formation;
use App\Imports\BulkImport;
use App\Imports\ImportModule;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UploadController extends Controller
{
    //
    public function import(Request $request){
        $bulk = new BulkImport;
        $etudiants = [];
        //$request->file('file')[0]->store('templates','public');
        foreach($request->file('file') as $file){
            $array = Excel::toArray($bulk,$file);
            $etudiants = array_merge($etudiants , $bulk->treat($array));

        }
        $content = 'etudiant.index';
        $import = true;
        $formations = Formation::get();
        return view('admin',compact(['formations','content','etudiants','import']));
    }
    public function export(){
        return Excel::download(new EtudiantsExport , 'etudiant.xlsx');
    }
    public function exportAllFormations(){
        return Excel::download(new ExportFormations(),'etudiants.xlsx');
    }
    public function exportnotes($id){
        if(is_numeric($id)){
            return Excel::download(new NotesExport($id),'notes.xlsx');
        }
        else{
            return redirect(route('etudiant.evaluation'));
        }
    }
    public function exportModule($sem_id,$module_id,$session,$type){
        if(is_numeric($sem_id) && is_numeric($module_id) && is_numeric($session) ){
            return Excel::download(new ModuleExport($sem_id,$module_id,$session,$type),'modules.xlsx');
        }else{
            return redirect(route('etudiant.evaluation'));
        }
    }
    public function importNoteModule($sem_id,$module_id,$session,Request $request){
        $import_module =  new ImportModule($sem_id,$module_id,$session);
        $import_module->import($request->file('file'));

        return redirect(route('etudiant.evaluation'));
    }

}

<?php

namespace App\Http\Controllers;

use App\Etudiant;
use App\Formation;
use App\Imports\BulkImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UploadController extends Controller
{
    //
    public function import(Request $request){
        $bulk = new BulkImport;
        $etudiants = [];
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

    }

}

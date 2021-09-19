<?php

namespace App\Http\Controllers;

use App\Paiement;
use App\Professeur;
use App\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index(){
        $content = "teacher.index";
        $teachers = Teacher::get();
        return view('admin',compact(['teachers','content']));
    }
    public function create(){
        $content = "teacher.create";
        $teachers = Teacher::get();
        return view('admin',compact(['content']));
    }
    public function store(Request $request){
        $request->validate([
            'id'=>'required|unique:teachers',
            'first_name'=>'required',
            'last_name'=>'required'
        ]);
        Teacher::create($request->all());
        return redirect(route('teacher.index'));
    }
    public function edit($id){
        $content = "teacher.create";
        $teacher = Teacher::find($id);
        if($teacher){
            return view('admin',compact(['teacher','content']));
        }
    }
    public function update($id,Request $request){
        $teacher = Teacher::find($id);
        if($teacher){
            $request->validate([
                'id'=>'required',
                'first_name'=>'required',
                'last_name'=>'required'
            ]);
            Teacher::create($request->all());
        }
        return redirect(route('teacher.index'));
    }
    public function destroy($id){
        $teacher = Teacher::find($id);
        if($teacher){
            foreach($teacher->professeurs as $prof){
                Professeur::destroy($prof->id);
            }
            foreach($teacher->paiements as $paiement){
                Paiement::destroy($paiement->id);
            }
        }
        Teacher::destroy($id);
        return redirect(route('teacher.index'));
    }
}

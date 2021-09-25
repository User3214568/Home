<?php

namespace App\Http\Controllers;

use App\Paiement;
use App\Professeur;
use App\Teacher;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
            'cin'=>'required|unique:users,cin',
            'first_name'=>'required',
            'last_name'=>'required'
        ]);
        $user = User::create([
            'cin'=>$request->cin,
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'email'=>$request->last_name.".".$request->first_name."@gest.ma",
            'password'=>bcrypt(strtoupper($request->first_name)."@".strtoupper($request->last_name)),
            'type'=>1
        ]);
        Teacher::create(['user_cin'=>$request->cin]);
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
                'cin'=>'required|unique:teachers,user_cin,'.$teacher->user_cin,
                'first_name'=>'required',
                'last_name'=>'required'
            ]);
            $teacher->user->update(array_merge($request->only(['first_name','last_name']),['cin'=>$request->cin]));
            $teacher->update(['user_cin'=>$request->cin]);
        }
        return redirect(route('teacher.index'));
    }
    public function destroy($id){
        $teacher = Teacher::find($id);
        if($teacher){
            if($teacher->professeurs != null){

                foreach($teacher->professeurs as $prof){
                    Professeur::destroy($prof->id);
                }
            }
            if($teacher->paiements != null){

                foreach($teacher->paiements as $paiement){
                    Paiement::destroy($paiement->id);
                }
            }
            Teacher::destroy($id);
            User::destroy($teacher->user_cin);
        }
        return redirect(route('teacher.index'));
    }

    public function homepage(){
        return view('enseignant');
    }
    public function teacherNotes(){
        $professeurs = Professeur::with('formation','module')->get()->groupBy(['formation.name','module.name']);
        $content = 'parts.enseignant.notes.notes';
        if($professeurs){
            return view('enseignant',compact(['professeurs','content']));
        }
    }
}

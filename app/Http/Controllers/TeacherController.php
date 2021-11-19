<?php

namespace App\Http\Controllers;

use App\Evaluation;
use App\Formation;
use App\Paiement;
use App\Professeur;
use App\Scopes\ProfesseurScope;
use App\Teacher;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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
                'first_name'=>'required',
                'last_name'=>'required'
            ]);
            $teacher->user->update($request->only(['first_name','last_name']));
        }
        return redirect(route('teacher.index'));
    }
    public function destroy($id){
        $teacher = Teacher::find($id);
        if($teacher){
            $profs = Professeur::withoutGlobalScope(ProfesseurScope::class)->where('teacher_id',$teacher->id);
            if($profs != null){

                foreach($profs as $prof){
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
        $affectations = Professeur::withoutGlobalScope(ProfesseurScope::class)->where('teacher_id',Auth::user()->teacher->id)->get()->sortBy('created_at')->groupBy(function($val) {
            return Carbon::parse($val->created_at)->format('Y');
        });;
        return view('enseignant',compact(['affectations']));
    }

    public function teacherNotes(){
        $auth_formations = Auth::user()->teacher->authModules();

        $content = 'parts.enseignant.notes.notes';
        $formations = Formation::get();
        return view('enseignant',compact(['formations','auth_formations','content']));

    }
    public function paiements(){
        $paiements = Auth::user()->teacher->paiements;
        $content = 'parts.enseignant.paiements.paiements';

        return view('enseignant',compact(['paiements','content']));
    }
}

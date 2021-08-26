<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        $content = 'user.index';
        $users = User::get();
        return view('admin',compact(['content','users']));
    }
    public function create(){
        $content = 'user.create';
        return view('admin',compact(['content']));
    }
    public function edit($id){
        $content = 'user.update';
        $user = User::find($id);
        if(isset($user)) return view('admin',compact(['content','user']));
    }
    public function store(Request $request){
        $is_valid = $request->validate([
            'first_name'=>'required |max:50',
            'last_name'=>'required |max:50',
            'cin'=>'required|unique:Etudiants|max:15',
            'email'=>'required|max:30',
            'password'=>'required',
            'phone'=>'required|max:30'
        ]);
        if($is_valid){
            $pass_hashed = Hash::make($request->password);
            User::create(array_merge($request->only(['first_name','last_name','cin','email','phone']) , ['password'=>$pass_hashed]));
        }
        if(!isset($request->ajax))
        return redirect(route('user.create'));
    }
    public function update($id , Request $request){
        User::find($id)->update(array_merge($request->only(['first_name','last_name','cin','email','phone']),['password'=> Hash::make($request->password)]));
        return $this->edit($id);
    }
    public function login(Request $request){
        $result = Auth::attempt($request->only(['email','password']));
        if($result){
            return redirect('/admin');
        }
        else{
            return view('login',['alreadyFailed'=>true]);
        }

    }
    public function logout(){
        Auth::logout();
        return redirect('/');
    }

}

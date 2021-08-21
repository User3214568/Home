<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function login(Request $request){

        $result = Auth::attempt($request->only(['email','password']));
        return redirect('/admin');

    }
    public function logout(){
        Auth::logout();
        return redirect('/');
    }

}

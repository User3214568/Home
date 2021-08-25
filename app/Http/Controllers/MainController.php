<?php

namespace App\Http\Controllers;



class MainController extends Controller
{
    public function index(){

        return view('index');
    }
    public function login(){
        return view('login');
    }
    public function restorePassword(){
        return view('pass-forg');
    }
    public function admin(){
        return view('admin');
    }
}

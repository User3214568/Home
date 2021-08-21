<?php

namespace App\Http\Controllers;

use App\Module;
use Illuminate\Http\Request;

class FormationController extends Controller
{
    public function index(){
        return view('');
    }

    public function create(){
        $content = 'formation.create';
        
        return view('admin',compact(['content','modules']));
    }
}

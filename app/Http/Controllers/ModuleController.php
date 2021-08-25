<?php

namespace App\Http\Controllers;

use App\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index(){

    }
    public function edit($id){
        $content = 'module.update';
        $module = Module::find($id);
        return view('admin',compact('content','module'));
    }
    public function update($id , Request $request){
        $content = 'module.update';
        $validated  = $request->validate([
            'name'=>'required|max:255',
            'description'=>'required'
        ]);

        if($validated){
            Module::find($id)->update($request->only(['name','description']));
            return view('admin',compact('content','module'));
        }

    }
    public function create(){
        $content = 'module.create';
        return view('admin',compact('content'));
    }
    public function store(Request $request){
        $validated  = $request->validate([
            'name'=>'required|unique:modules|max:255',
            'description'=>'required'
        ]);

        if($validated){
            Module::create(['name'=>$request->name,'description'=>$request->description,'index'=>0]);
        }
        else{

        }
        return $this->create();
    }
}

<?php

namespace App\Http\Controllers;

use App\Devoir;
use App\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index(){
        $content = 'module.index';
        $modules = Module::get();
        return view('admin',compact(['modules','content']));
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
            $devoirs =json_decode($request->devoirs,true);

            foreach ($devoirs as $key => $value) {
                if(preg_match('/^[0-9]+$/',$key)){
                    $ratio = $value['ratio'];
                    if(!preg_match('/^[0-9]+(\.[0-9]+)?$/',$ratio)){
                        $ratio = 0;
                    }
                    if(isset($value['id'])){
                        $dv = Devoir::find($value['id']);

                        $dv->update(['name'=>$value['name'] , 'ratio'=>$ratio]);
                    }else{
                        Devoir::create(['name'=>$value['name'] ,'session'=>$value['session'] ,  'ratio'=>$ratio,'module_id'=>$id]);
                    }
                }else{
                    if($key == "toDelete"){
                        Devoir::destroy($value);
                    }
                }

            }
            return $this->index();
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
            $module = Module::create(['name'=>$request->name,'description'=>$request->description,'index'=>0]);
            $devoirs =json_decode($request->devoirs,true);
            foreach ($devoirs as $key => $value) {
                if(preg_match('/^[0-9]+$/',$key)){
                    $ratio = $value['ratio'];
                    if(!preg_match('/^[0-9]+(\.[0-9]+)?$/',$ratio)){
                        $ratio = 0;
                    }
                    Devoir::create(['name'=>$value['name'] , 'ratio'=>$ratio,'session'=>$value['session'],'module_id'=>$module->id]);
                }

            }
        }
        return $this->create();
    }
    public function destroy($id){
        Module::destroy($id);
        return $this->index();
    }
}

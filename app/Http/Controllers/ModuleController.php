<?php

namespace App\Http\Controllers;

use App\Devoir;
use App\Evaluation;
use App\Module;
use App\Promotion;
use App\Utilities\Validation;
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
            return redirect(route('module.index'));
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
        return redirect(route('module.index'));
    }
    public function destroy($id){
        $module = Module::find($id);
        if($module){
            foreach($module->devoirs as $dev){
                foreach($dev->evaluations as $eval){
                    Evaluation::destroy($eval->id);
                }
                Devoir::destroy($dev->id);
            }
        }
            Module::destroy($id);

            return redirect(route('module.index'));
        }
    public function commitOrdinaireSession($promo_id,$sem_id,$module_id){
        $promotion = Promotion::find($promo_id);
        if($module_id == 0 && $promotion){
            foreach ($promotion->semestres  as $semestre) {
                if($semestre->id == $sem_id){
                    foreach ($semestre->modules as $module) {
                        $this->commit($promotion,$module);
                    }
                }
            }

        }
        else{
            $module = Module::find($module_id);
            if($module && $promotion){
                $this->commit($promotion,$module);
            }
        }
        return redirect(route('etudiant.evaluation'));
    }
    private function commit($promotion , $module){
        foreach ($promotion->etudiants as $etudiant) {
            foreach ($etudiant->evaluations as $evaluation) {
                if($evaluation->devoir->session == 2){
                    $evaluation->delete();
                }
            }
            if(!(Validation::OrdinaireValidateModule($etudiant->cin,$module->id) == "Validé")){
                foreach ($module->devoirs as $devoir) {
                    if($devoir->session == 2){
                        Evaluation::create(['etudiant_cin'=>$etudiant->cin,'devoir_id'=>$devoir->id]);
                    }
                }
            }else{
                // To Delete Evaluations that Exists as Old Result.
            }
        }
    }
}

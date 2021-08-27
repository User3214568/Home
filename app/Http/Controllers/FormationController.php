<?php

namespace App\Http\Controllers;

use App\Formation;
use App\Module;
use App\Promotion;
use App\Semestre;
use Illuminate\Http\Request;

class FormationController extends Controller
{
    public function index(){
        $content = 'formation.index';
        $formations = Formation::get();
        return view('admin',compact(['formations','content']));
    }

    public function create(){
        $content = 'formation.create';
        $modules = Module::get();
        $semestres = Semestre::with('modules')->get();
        return view('admin',compact(['content','semestres','modules']));

    }
    public function store(Request $request){

        $isvalid = $request->validate([
            'name'=>'required|unique:formations|max:255',
            'description'=>'required'
        ]);
        if($isvalid){
            $semestres = json_decode($request->semestres,true);
            $formation = Formation::create($request->only(['name','description']));
            $promo = Promotion::create(['numero'=>1,'nom'=>'1ère Année','formation_id'=>$formation->id]);
            foreach($semestres as $semestre => $modules){
                $create_sem  = Semestre::create(['numero'=>$semestre , 'formation_id'=>$formation->id,'promotion_id'=>$promo->id]);
                $create_sem->modules()->attach($modules);

                if($semestre%2 == 0){
                    $promo = Promotion::create(['numero'=>(1+(($semestre)/2)),'nom'=>(1+(($semestre)/2)).'ére Année','formation_id'=>$formation->id]);
                }
            }

            return redirect(route('formation.create'));
            return $this->index();
        }
        else{
            return route('etudiant.create');
        }
    }
    public function edit($id){
        $content = 'formation.update';
        $formation = Formation::with('semestres')->find($id);
        if( $formation->semestres != null){
            $formation->semestres->ids = [];
            foreach($formation->semestres as $semestre){
                $modules_id = [];
                foreach($semestre->modules as $module){
                    array_push($modules_id,$module->id);
                }
                $formation->semestres->ids[$semestre->numero] = $modules_id;
            }
        }

        $modules = Module::get();
        $semestres = Semestre::with('modules')->get();
        return view('admin',compact(['content','semestres','modules','formation']));
    }
    public function update($id , Request $request){
        $isvalid = $request->validate([
            'name'=>'required|max:255',
            'description'=>'required'
        ]);
        if($isvalid){
            $semestres = json_decode($request->semestres,true);
            $formation = Formation::with('semestres')->find($id);
            $formation->update($request->only(['name','description']));
            $promo = Promotion::create(['numero'=>1,'nom'=>'1ère Année','formation_id'=>$id]);
            # deleting old semestres and make new ones

            foreach($formation->semestres as $semestre){
                $semestre->delete();
            }
            if(isset($semestres)){

                foreach($semestres as $semestre => $modules){
                    if($semestre !=null){
                        $create_sem  = Semestre::create(['numero'=>$semestre , 'formation_id'=>$formation->id]);
                        $create_sem->modules()->attach($modules);
                        $create_sem  = Semestre::create(['numero'=>$semestre , 'formation_id'=>$formation->id,'promotion_id'=>$promo->id]);
                        if(($semestre%2 == 0)){
                            $promo = Promotion::create(['numero'=>(1+(($semestre)/2)),'nom'=>(1+(($semestre)/2)).'ére Année','formation_id'=>$id]);
                        }

                    }


                }

                return $this->index();
            }

        }
        return $this->create();

    }
    public function destroy($id){
        $formation = Formation::with('semestres')->find($id);

        if(isset($formation)){
            foreach($formation->semestres as $sem){
                Semestre::destroy($sem->id);
            }
        }
        Formation::destroy($id);
        return $this->index();
    }
    public function notes(Request $request){
        if(isset($request->id)){
            $formation = Formation::find($request->id);
            return response(view('parts.admin.etudiant.tabnotes',compact(['formation'])),200);
        }
        else{
            return response('Not Found',404);
        }
    }
}

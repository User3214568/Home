<?php

namespace App\Imports;

use App\Evaluation;
use App\Exceptions\ImportException;
use App\Module;
use App\Semestre;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Throwable;

class ImportModule implements ToModel,WithHeadingRow,SkipsOnError,WithValidation
{
    use Importable,SkipsErrors;
    private $semstre;
    private $module;
    private $session;
    private $counter;
    public function __construct($sem,$mod,$sess){
        $this->semestre = Semestre::find($sem);
        $this->module = Module::find($mod);
        $this->session = $sess;

        if(!$this->session || !$this->module || !$this->semestre){
            throw new ImportException("On n'a pas pu trouver le module ou la semestre concerné par cette importation.");
        }
    }

    /**
    * @param Collection $collection
    */
    public function model($array){
        $i = 5 ;
        try{

            foreach ($this->module->devoirs as $devoir) {
                $col = strtolower($devoir->name);
                $col = str_replace(' ','_',$col);
                if(isset($array[$col])){
                    $etudiant_cin = User::find($array['cin'])->etudiant->cin;
                    $evaluation_id = Evaluation::eems($etudiant_cin,$devoir->id,$this->session);
                    if(! ($evaluation_id instanceof  Builder)){
                        Evaluation::find($evaluation_id)->update(['note'=> ($array[$col])]);
                    }
                }
                $i++;
            }

        }catch(Exception $e){
            throw new ImportException($e->getMessage());
        }
    }

    public function headingRow():int {
        return 15;
    }
    public function rules(): array
    {
        $rules = ['cin'=>['required']];
        foreach ($this->module->devoirs as $devoir) {
            if($devoir->session == $this->session){
                $col = strtolower($devoir->name);
                $col = str_replace(' ','_',$col);
                $rules["*.".$col] = ['required','numeric'];
            }
        }
        return $rules;
    }
    public function onError(Throwable $e)
    {

    }

}

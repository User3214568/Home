<?php

namespace App\Imports;

use App\Evaluation;
use App\Module;
use App\Semestre;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMappedCells;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\BeforeImport;
use Throwable;

class ImportModule implements ToModel,WithHeadingRow,SkipsOnError
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
    }

    /**
    * @param Collection $collection
    */
    public function model($array){
        $i = 5 ;
        foreach ($this->module->devoirs as $devoir) {
            if(isset($array[strtolower($devoir->name)])){
                $evaluation_id = Evaluation::eems($array['cin'],$devoir->id,$this->session);
                if(! ($evaluation_id instanceof  Builder)){
                    Evaluation::find($evaluation_id)->update(['note'=> ($array[strtolower($devoir->name)])]);
                }
            }
            $i++;
        }

    }

    public function headingRow():int {
        return 15;
    }
    public function onError(Throwable $e)
    {

    }

}

<?php

namespace App\Imports;

use App\Bulk;
use App\Etudiant;
use App\Formation;
use App\Http\Controllers\FormationController;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BulkImport implements ToArray
{
    private $formation = null;
    private $promo = null;
    private $year = null;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function array(array $row)
    {

    }
    public function treat($rows){
        $etudiants = [];
        foreach($rows[0] as $row){

            $etudiant = "";
            if($row[1] != null) {
                if($row[1] == "Formation"){
                    $this->formation = $row[2];
                    $this->year = $row[6];

                }
                if($row[1] == "Niveau"){
                    $this->promo = $row[2];
                }
                if(preg_match('/[0-9]+/',$row[1])){
                    if($this->formation != null){
                        $formation_id = Formation::name($this->formation)->get()[0]->id;
                        $etudiant = new Etudiant([
                            'cne'=>$row[2],
                            'first_name'=>$row[3] ,
                            'last_name'=> $row[4],
                            'cin'=> $row[5],
                            'born_date'=>date('Y-m-d',strtotime($row[6])),
                            'email'=>$row[7],
                            'formation_id'=>$formation_id
                        ]);
                        array_push($etudiants,$etudiant);
                    }

                }
                //return compact(['rowType','etudiant','formation','promo','year']);
            }
        }
        return $etudiants;
    }
}

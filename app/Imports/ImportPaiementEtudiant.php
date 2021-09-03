<?php

namespace App\Imports;

use App\Etudiant;
use App\Paiement;
use App\Tranche;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ImportPaiementEtudiant implements ToModel,WithHeadingRow,WithHeadings
{
    public function model(array $row)
    {
        $cin = $row['cin'];
        $count = 1;
        $etudiant = Etudiant::find($cin);
        if($etudiant){
            for($i = 3 ; $i+2 < sizeof($row) ; $i+=3){
                if(isset($row["vers$count"])){
                    $date = date_create_from_format('d-m-Y', $row["date".($count)]);
                    $date = date_format($date,'Y-m-d');
                    foreach ($etudiant->tranches as  $tranche) {
                        Tranche::destroy($tranche->id);
                    }
                    $prove = (stripos($row["ref$count"],"rien")===false?false:true);
                    Tranche::create(['vers'=>$row["vers$count"],'proved'=>!$prove,'ref'=>$row["ref".($count)],'date_vers'=>$date,'etudiant_cin'=>$cin]);
                    $count++;
                }
            }

        }

    }
    public function headingRow():int{
       return 11;
    }
    public function headings(): array
    {
        $header = ['nom','prénom','cin','vers1','ref1','date1','vers2','ref2','date2','vers3','ref3','date3','vers4','ref4','date4'];
        return $header;
    }


}

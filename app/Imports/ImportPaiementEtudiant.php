<?php

namespace App\Imports;

use App\Etudiant;
use App\Exceptions\ImportException;
use App\Paiement;
use App\Tranche;
use Exception;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ImportPaiementEtudiant implements ToModel, WithHeadingRow, WithHeadings, WithValidation
{
    public function model(array $row)
    {
        $cin = $row['cin'];
        $count = 1;
        $etudiant = Etudiant::find($cin);
        if ($etudiant) {
            try {
                for ($i = 3; $i + 2 < sizeof($row); $i += 3) {
                    if (isset($row["vers$count"])) {
                        $date = Date::excelToDateTimeObject($row["date" . ($count)])->format('Y-m-d');
                        foreach ($etudiant->tranches as  $tranche) {
                            Tranche::destroy($tranche->id);
                        }
                        if ($row["ref$count"] == null) {
                            $row["ref$count"] = "-";
                            $prove = true;
                        } else {
                            $prove = (stripos($row["ref$count"], "rien") === false ? false : true);
                        }
                        Tranche::create(['vers' => $row["vers$count"], 'proved' => !$prove, 'ref' => $row["ref" . ($count)], 'date_vers' => $date, 'etudiant_cin' => $cin]);
                        $count++;
                    }
                }
            } catch (Exception $e) {
                throw new ImportException($e->getMessage());
            }
        }else throw new ImportException("On n'a pas pu trouver l'etudiant concerné dont le cin : $cin");
    }
    public function headingRow(): int
    {
        return 11;
    }
    public function headings(): array
    {
        $header = ['nom', 'prénom', 'cin', 'vers1', 'ref1', 'date1', 'vers2', 'ref2', 'date2', 'vers3', 'ref3', 'date3', 'vers4', 'ref4', 'date4'];
        return $header;
    }
    public function rules(): array
    {
        return [
            'cin' => ['required'],
        ];
    }
}

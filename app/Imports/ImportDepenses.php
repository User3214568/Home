<?php

namespace App\Imports;

use App\Depenses;
use App\Exceptions\ImportException;
use Exception;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ImportDepenses implements ToModel,WithHeadingRow,WithValidation
{
    public function model(array $row)
    {
        try{
            Depenses::create(['name'=>$row['motif'],'somme'=>$row['somme']]);
        }catch(Exception $e){
            throw new ImportException($e->getMessage());
        }

    }
    public function headingRow():int{
        return 11;
    }
    public function rules(): array
    {
        return [
            '*.motif'=>['required'],
            '*.somme'=>['required','numeric']
        ];
    }
}

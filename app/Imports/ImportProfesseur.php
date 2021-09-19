<?php

namespace App\Imports;

use App\Exceptions\ImportException;
use App\Module;
use App\Professeur;
use App\Teacher;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ImportProfesseur implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    public function __construct($formation)
    {
        $this->formation = $formation;
    }
    /**
     * @param Collection $collection
     */
    public function model(array $row)
    {
        $result = $this->validate($row) ;
        if ($result) {
            $module = Module::get()->where('name', $row['module'])->first();
            $teacher = Teacher::find($result);
            if ($module) {

                $prof = Professeur::with('teacher')->get()->where('module', $module)->where('formation_id', $this->formation->id)->where('teacher.id', $result)->first();

                if ($prof) {
                    $prof->update(['somme' => $row['somme']]);
                } else {
                    $teacher  = Teacher::find($result);
                    if($teacher){
                        Professeur::create([
                            'module_id' => $module->id,
                            'somme' => $row['somme'],
                            'formation_id' => $this->formation->id,
                            'teacher_id' => $teacher->id
                        ]);
                    }
                }
            }
        }
    }
    private function validate($row)
    {
        $teacher = false;
        if($row['informations_du_professeur'] !== null && $row['somme'] !== null  && is_numeric($row['somme']) ){
            $arr = explode(' : ',$row['informations_du_professeur']);
            $teacher = $arr[0];
        }

        return $teacher;
    }
    public function headingRow(): int
    {
        return 11;
    }
    public function rules(): array
    {
        return [
            'module' => ['string'],
        ];
    }
}

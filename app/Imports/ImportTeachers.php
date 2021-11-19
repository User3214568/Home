<?php

namespace App\Imports;

use App\Teacher;
use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ImportTeachers implements ToModel, WithHeadingRow,WithValidation
{
    /**
    * @param Collection $collection
    */
    public function model($row)
    {
        $user = User::create([
            'cin'=>$row['cin'],
            'first_name'=>$row['nom'],
            'last_name'=>$row['prenom'],
            'password'=>bcrypt(strtoupper($row['nom'])."@".strtoupper($row['prenom'])),
            'type'=>1,
            'phone'=>$row['telephone'],
            'email'=>$row['email']
        ]);
        Teacher::create(['user_cin'=>$user->cin]);
    }
    public function headingRow():int{
        return 11;
    }
    public function rules(): array
    {
        return [
            '*.cin'=>['required','unique:users,cin'],
            '*.nom'=>['required'],
            '*.prenom'=>['required'],
            '*.email'=>['email','required','unique:users,email'],
            '*.telephone'=>['required']
        ];
    }
}

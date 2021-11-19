<?php
namespace App\Utilities;

class Generate{

    public static function background_color(){
        $r = rand(0,200);
        $g = rand(0,200);
        $b = rand(0,200);
        if($r >= 190 && $g >=190 && $b >=190){
            $r = 45;
        }
        return "background-color : rgb($r,$g,$b);";
    }
}

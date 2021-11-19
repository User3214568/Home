<?php

namespace App\Utilities;

use Carbon\Carbon;

class Calculation {
    public static function time_diff($start,$end=null){
        if($end == null) $end = now();
        $cstart = Carbon::parse($start);
        $cend = Carbon::parse($end);
        $diff_y = $cend->diffInYears($cstart);
        $diff_mn = $cend->diffInMonths($cstart);
        $diff_w = $cend->diffInWeeks($cstart);
        $diff_d = $cend->diffInDays($cstart);
        $diff_h = $cend->diffInHours($cstart);
        $diff_m = $cend->diffInMinutes($cstart);
        $diff_s = $cend->diffInSeconds($cstart);
        if($diff_y == 0 ){
            if($diff_mn == 0){
                if($diff_w == 0){
                    if($diff_d == 0 ){
                        if($diff_h == 0){
                            if($diff_m == 0){
                                return $diff_s. " s";
                            }
                            return $diff_m. " min";
                        }
                        return $diff_h. " h";
                    }
                    return $diff_d. " j";
                }
                return $diff_w. " sem";
            }
            return $diff_mn. " mois";
        }
        return $diff_y. " année(s)";
    }

}

?>

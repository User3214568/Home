<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EtudiantModule extends Pivot
{
    public function devoirs(){
        return $this->hasMany(Devoir::class,'etudiant_module_id');
    }
}

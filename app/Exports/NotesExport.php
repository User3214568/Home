<?php

namespace App\Exports;

use App\Formation;
use App\Promotion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class NotesExport implements WithMultipleSheets
{
    private $formation_id;

    public function __construct($id)
    {
        $this->formation_id = $id;
    }
    public function sheets(): array
    {
        $formation = Formation::find($this->formation_id);
        $sheets = [];
        foreach ($formation->promotions as $promo) {
            $modules_count = 1;
            foreach ($promo->semestres as $s) {
                foreach ($s->modules as $k => $module) {
                    $modules_count++;
                }
            }
            $sheets[] = new PromotionNotesExport($promo,$modules_count+8);
        }
        return $sheets;
    }
}

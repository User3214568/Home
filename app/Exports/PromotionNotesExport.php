<?php

namespace App\Exports;

use App\Promotion;
use App\Utilities\Validation;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\WithColumnWidths;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

use Maatwebsite\Excel\Concerns\WithTitle;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PromotionNotesExport extends TemplateExport implements FromCollection,WithColumnWidths,WithTitle,WithMapping,WithHeadings
{
    private $promotion;

    private $header_size;
    private $start_row ;
    public function __construct($promo,$head_size)
    {
        parent::__construct($promo->formation->name,'PV Résultats',$head_size);
        $this->header_size = $head_size;
        $this->promotion  = $promo;
        $this->start_row = 11;
    }

    public function additionalStyles(Worksheet $sheet,$styles)
    {

        for ($i = $this->start_row; $i <= sizeof($this->promotion->etudiants)+$this->start_row; $i++) {
            for($j = 0 ; $j < $this->header_size ; $j++){
                $styles[(chr(65+$j)."$i")]['borders'] = [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE
                    ],
                ];
            }
        }
        $count = 1;
        foreach ($this->promotion->semestres as $sem) {
            foreach ($sem->modules as $module) {
                $sheet->getCell("A" . (sizeof($this->promotion->etudiants) + $this->start_row + 1 + $count))->setValue("M$count");
                $styles["A" . (sizeof($this->promotion->etudiants) + $this->start_row + 1 + $count)]['borders'] = [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                    ],
                ];
                $sheet->getCell("B" . (sizeof($this->promotion->etudiants) + $this->start_row + 1 + $count))->setValue($module->name);
                $styles["B" . (sizeof($this->promotion->etudiants) + $this->start_row + 1 + $count)]['borders'] = [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                    ],
                ];
                $count++;
            }

        }
        for ($i = 0; $i < $this->header_size; $i++) {
            $styles[chr(65 + $i)] = ['font' => ['size' => 15]];
            $styles[chr(65 + $i)]['alignment'] = [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ];
        }
        return $styles;
    }

    public function collection()
    {
        return $this->promotion->etudiants;
    }

    public function headings(): array
    {
        $heads = ['Nom', 'Prénom', 'CIN', 'Date Naissance', 'Lieu Naissance'];
        $modules_count = 1;
        foreach ($this->promotion->semestres as $s) {
            foreach ($s->modules as $k => $module) {
                array_push($heads, "M" . $modules_count);
                $modules_count++;
            }
        }
        array_push($heads, "Moy", "Résultat", "Mention");
        $this->header_size = sizeof($heads);
        return $heads;
    }
    public function map($etudiant): array
    {
        $row = [
            $etudiant->first_name,
            $etudiant->last_name,
            $etudiant->cin,
            $etudiant->born_date,
            $etudiant->cne,
        ];
        $moy = 0;
        $count = 0;
        foreach ($this->promotion->semestres as $s) {
            foreach ($s->modules as $module) {
                $mavg = Validation::FinalModuleNote($etudiant->cin,$module->id);
                $moy += $mavg;
                $count++;

                array_push($row, $mavg >= 10 ? " ".number_format($mavg,2)." ":"0".number_format($mavg,2));

            }
        }
        $moy = ($count > 0) ? $moy / $count : '-';
        $mention = "Très Bien";
        if ($moy < 16) {
            $mention = "Bien";
            if ($moy < 14) {
                $mention = 'Assez Bien';
            }
            if ($moy < 12) {
                $mention = "Faible";
            }
        }
        array_push($row, $moy >= 10 ? " ".number_format($moy,2)." ":"0".number_format($moy,2), $moy >= 12 ? 'admis' : 'non admis', $mention);
        return $row;
    }
    public function title(): string
    {
        return $this->promotion->nom;
    }


    public function columnWidths(): array
    {
        $widths = [
            'A' => 20,
            'B' => 35,
            'C' => 19,
            'D' => 22,
            'E' => 30,

        ];
        for ($i = 0; $i < $this->header_size - 8; $i++) {
            $widths[chr(70 + $i)] = 7;
        }
        $widths[chr(70 + $i)] = 25;
        $widths[chr(70 + $i + 1)] = 25;
        $widths[chr(70 + $i + 2)] = 25;
        return $widths;
    }

}

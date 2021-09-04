<?php

namespace App\Exports;

use App\Professeur;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportProfesseur extends TemplateExport implements FromArray, WithTitle, WithColumnWidths, WithHeadings, WithMapping
{
    public function __construct($formation, $empty = false)
    {
        $this->formation = $formation;
        $this->empty = $empty;
        parent::__construct($formation->name, "Liste des Professeurs et Leurs Sommes", 3);
    }
    public function additionalStyles(Worksheet $sheet, $styles)
    {

        for ($i = 0; $i < $this->size_rows; $i++) {
            for ($j = 0; $j < 3; $j++) {
                $styles[chr(65 + $j) . "" . ($i + 12)] = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                        ],
                    ],
                    'font'=>['size'=>13 ]

                ];
            }
        }

        return $styles;
    }
    public function array(): array
    {
        $modules = [];
        foreach ($this->formation->semestres as $semestre) {
            foreach ($semestre->modules as  $module) {
                array_push($modules, $module);
            }
        }
        $this->size_rows = sizeof($modules);
        return $modules;
    }
    public function headings(): array
    {
        return [
            'Module',
            'Nom du Professeur',
            'Somme'
        ];
    }
    public function map($module): array
    {
        $row = [];
        $professeur = Professeur::get()->where('module_id', $module->id)->where('formation_id', $this->formation->id)->first();
        if ($professeur) {
            $row = array_merge($row, [
                $module->name,
                $this->empty ? "" : $professeur->name,
                $this->empty ? "" : $professeur->somme
            ]);
        } else {
            $row = array_merge($row, [
                $module->name,
                "", ""
            ]);
        }
        return $row;
    }
    public function columnWidths(): array
    {
        return [
            'A' => 35,
            'B' => 45,
            'C' => 15
        ];
    }
    public function title(): string
    {
        return $this->formation->name;
    }
}

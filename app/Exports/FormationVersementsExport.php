<?php

namespace App\Exports;

use App\Etudiant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FormationVersementsExport extends TemplateExport  implements FromCollection, WithTitle, WithStrictNullComparison, WithColumnWidths, WithHeadings, WithMapping
{
    public function __construct($formation, $empty = false)
    {
        $this->formation = $formation;
        $this->etudiants = $formation->etudiants;
        $this->verificated = [];
        $this->versements = [];
        $this->count = 0;
        $this->empty = $empty;
        $this->start_row = 11;
        $this->header_size = 0;
        foreach ($this->etudiants->all() as $etudiant) {
            if ($etudiant->tranches && sizeof($etudiant->tranches) > 0) {
                $this->header_size = sizeof($etudiant->tranches);
            }
        }
        $this->header_size = max($this->header_size, 4);
        parent::__construct($formation->name, "Historique des Versement et des Paiement", ($this->header_size * 3) + 3 + (!$this->empty ? 2 : 0), $this->start_row);
        $this->header_size += (3 + (!$this->empty ? 2 : 0));
    }

    public function additionalStyles(Worksheet $sheet, $styles)
    {

        for ($i = 1; $i <= $this->count; $i++) {
            for ($j = 0; $j  < ($this->header_size - (!$this->empty ? 2 : 0) - 3) * 3 + 3 + (!$this->empty ? 2 : 0); $j++) {
                if ($i == 1) {
                    $styles[chr(65 + $j) . "" . $this->start_row] = [
                        'font' => ['size' => 14],
                        'borders' => [
                            'outline' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE
                            ],
                        ]
                    ];
                }
                $styles[chr(65 + $j) . "" . ($this->start_row + $i)] = [
                    'font' => ['size' => 14],
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE
                        ],
                    ]
                ];
            }
        }

        foreach ($this->verificated as $verified) {
            $color = $verified['verified'] ? '118f4a' : '32a6a8';
            $cell_last = $verified['cell']['column'];
            $cell_last++;
            $cell_last++;
            $styles[$verified['cell']['column'] . "" . $verified['cell']['row'].":".($cell_last) . "" . $verified['cell']['row']]['fill'] = [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => $color]
            ];
        }
        if (!$this->empty) {
            $i = 0;
            $total = 0;
            $styles = $this->makeLegend($sheet,$styles,66,$this->start_row,"ffbb00","TOTAL VERSEMENTS");
            $styles = $this->makeLegend($sheet,$styles,69,$this->start_row,"ffbb00","LEGEND");
            $styles = $this->makeLegend($sheet,$styles,69,$this->start_row+1,"118f4a","Versement Verifier");
            $styles = $this->makeLegend($sheet,$styles,69,$this->start_row+2,"32a6a8","Versement Non Verifier");
            foreach ($this->versements as $key => $vers) {
                $sheet->getCell('B' . ($this->count + 3 + $this->start_row + 1 + $key))->setValue('Total Versement ' . ($key + 1));
                $sheet->getCell('C' . ($this->count + 3 + $this->start_row + 1 + $key))->setValue(($vers));
                $total += $vers;
                $styles['B' . ($this->count + 3 + $this->start_row + 1 + $key)] = [
                    'font' => ['size' => 14],
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                        ],
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => ['rgb' => "32a6a8"]
                    ]
                ];
                $styles['C' . ($this->count + 3 + $this->start_row + 1 + $key)] = $styles['B' . ($this->count + 3 + $this->start_row + 1 + $key)];
            }
            $key++;
            $sheet->getCell('B' . ($this->count + 3 + $this->start_row + 1 + $key))->setValue('Total Vesements');
            $sheet->getCell('C' . ($this->count + 3 + $this->start_row + 1 + $key))->setValue($total);
            $styles['B' . ($this->count + 3 + $this->start_row + 1 + $key)] = [
                'font' => ['size' => 13, 'bold' => true],
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                    ],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['rgb' => "1d9dad"]
                ]
            ];
            $styles['C' . ($this->count + 3 + $this->start_row + 1 + $key)] = $styles['B' . ($this->count + 3 + $this->start_row + 1 + $key)];
        }
        return $styles;
    }
    public function makeLegend($sheet,$styles,$index1,$index2,$color,$value){
        $sheet->mergeCells(chr($index1) . '' . ($this->count + 3 + $index2) . ":" . chr($index1+1) . ($this->count + 3 + $index2));
                $sheet->getCell(chr($index1) . '' . ($this->count + 3 + $index2))->setValue($value);
                $styles[chr($index1) . '' . ($this->count + 3 + $index2) . ":" . chr($index1+1) . ($this->count + 3 + $index2)] = [
                    'font' => ['size' => 14, 'bold' => true],
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                        ],
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => ['rgb' => $color]
                    ]
                ];
                return $styles;
    }
    public function map($etudiant): array
    {
        $this->count++;
        $somme = 0;
        $row = [$etudiant->first_name, $etudiant->last_name, $etudiant->cin];
        if (!$this->empty) {
            $i = 0;
            foreach ($etudiant->tranches as $key => $tranche) {
                if (!isset($this->versements[$key])) {
                    $this->versements[$key] = $tranche->vers;
                } else {
                    $this->versements[$key] += $tranche->vers;
                }
                array_push($row, $tranche->vers, $tranche->ref, $tranche->date_vers);
                array_push(
                    $this->verificated,
                    [
                        'verified' => $tranche->proved,
                        'cell' => [
                            'column' => chr(68 + $key * 3),
                            'row' => ($this->start_row + $this->count)
                        ]
                    ]
                );
                $somme += $tranche->vers;
                $i++;
            }
            while (($this->header_size - 3 - (!$this->empty ? 2 : 0) - $i) > 0) {
                array_push($row, "", "", "");
                $i++;
            }

            array_push($row, $somme, 16000 - $somme);
        }

        return $row;
    }
    public function headings(): array
    {
        $heads = ['Nom', 'Prénom', 'CIN'];
        for ($i = 1; $i <= $this->header_size - 3 - (!$this->empty ? 2 : 0); $i++) {
            array_push($heads, "Vers$i", "Réf$i", "Date$i");
        }
        if (!$this->empty) {
            array_push($heads, 'Totale', 'Reste');
        }
        return $heads;
    }
    public function collection()
    {

        return Etudiant::get();
    }
    public function columnWidths(): array
    {
        $width  = [
            'A' => 30,
            'B' => 30,
            'C' => 25
        ];

        for ($i = 0; $i <= $this->header_size - 3 - (!$this->empty ? 2 : 0); $i += 1) {
            $width = array_merge($width, [
                chr(68 + $i * 3) => 10,
                chr(68 + $i * 3 + 1) => 30,
                chr(68 + $i * 3 + 2) => 20,
            ]);
        }

        return $width;
    }
    public function title(): string
    {
        return $this->formation->name;
    }
}

<?php

namespace App\Exports;

use App\Etudiant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FormationFinanceExport extends TemplateExport  implements FromCollection,WithStrictNullComparison ,WithColumnWidths, WithHeadings, WithMapping
{
    public function __construct($formation,$empty = false)
    {
        $this->formation = $formation;
        $this->etudiants = $formation->etudiants;
        $this->verificated = [];
        $this->count = 0;
        $this->empty = $empty;
        $this->start_row = 11;
        $this->header_size = 0;
        foreach ($this->etudiants->all() as $etudiant) {
            if ($etudiant->tranches && sizeof($etudiant->tranches) > 0) {
                $this->header_size = sizeof($etudiant->tranches);
            }
        }

        $this->header_size = max($this->header_size,4);

        parent::__construct($formation->name, "Historique des Versement et des Paiement", ($this->header_size * 3 ) + 3 + (!$this->empty?2:0), $this->start_row);
        $this->header_size += (3+(!$this->empty?2:0));

    }

    public function additionalStyles(Worksheet $sheet, $styles)
    {

        for ($i = 1 ; $i <= $this->count;$i++) {
            for($j = 0 ; $j  < ($this->header_size-(!$this->empty?2:0)-3)*3+3+(!$this->empty?2:0) ; $j++){
                if($i == 1){
                    $styles[chr(65+$j)."".$this->start_row] = [
                        'font' => ['size' => 14],
                        'borders' => [
                            'outline' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE
                            ],
                        ]
                    ];
                }
                $styles[chr(65+$j)."".($this->start_row+$i)]= [
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
            $styles[$verified['cell']['column'] . "" . $verified['cell']['row']]['fill'] = [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => $color]
            ];

        }

        return $styles;
    }

    public function map($etudiant): array
    {
        $this->count++;
        $somme = 0;
        $row = [$etudiant->first_name, $etudiant->last_name, $etudiant->cin];
        if(!$this->empty){
            $i = 0 ;
            foreach ($etudiant->tranches as $key => $tranche) {
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
                $somme+=$tranche->vers;
                $i++;
            }
            while( ($this->header_size-3 - (!$this->empty?2:0) - $i) > 0 ){
                array_push($row, "", "","");
                $i++;
            }

            array_push($row,$somme,16000-$somme);
        }

        return $row;
    }
    public function headings(): array
    {
        $heads = ['Nom', 'Prénom', 'CIN'];
        for ($i = 1; $i <= $this->header_size - 3 -(!$this->empty?2:0); $i++) {
            array_push($heads, "Vers$i", "Réf$i", "Date$i");
        }
        if(!$this->empty){
            array_push($heads,'Totale','Reste');
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

        for ($i = 0; $i <= $this->header_size - 3 -(!$this->empty?2:0); $i+=1) {
            $width = array_merge($width, [
                chr( 68 + $i*3 ) => 10,
                chr(68 + $i*3 + 1) => 30,
                chr(68 + $i*3 + 2) => 20,
            ]);
        }

        return $width;
    }
}

<?php

namespace App\Exports;

use App\Promotion;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Reader\Xml\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat as StyleNumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PromotionNotesExport implements FromCollection,WithColumnFormatting ,WithDrawings, WithHeadings, WithColumnWidths, WithCustomStartCell, WithStartRow, WithMapping, WithTitle, WithStyles
{
    private $promotion;
    private $type;
    private $header_size;
    private $start_row ;
    public function __construct($promo, $type)
    {
        $this->promotion  = Promotion::find($promo);
        $this->type = $type;
        $this->start_row = 11;
    }

    public function collection()
    {
        return $this->promotion->etudiants;
    }

    public function headings(): array
    {
        $heads = ['Nom', 'Prénome', 'CIN', 'Date Naissance', 'Lieu Naissance'];
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
                $mavg = $etudiant->moduleAverage($module->id, 1);
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
    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells("A2:" . chr($this->header_size + 65 - 1) . '2');
        $sheet->mergeCells("A4:" . chr($this->header_size + 65 - 1) . '6');
        $sheet->getCell('A2')->setValue("Université Sultan Moulay Slimane\nEcole Nationale des Sciences Appliquées Khouribga\nCentre de Formation Continue");

        $sheet->mergeCells("A8:" . chr($this->header_size + 65 - 1) . '9');
        $sheet->getCell('A8')->setValue("PV Résultats");

        $sheet->getStyle('A2')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setVertical('center');

        $sheet->getCell('A4')->setValue($this->promotion->formation->name);
        $sheet->getStyle('A4')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A4')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A4')->getAlignment()->setVertical('center');
        $sheet->getStyle('A8')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A8')->getAlignment()->setVertical('center');
        $sheet->getRowDimension(2)->setRowHeight(61);
        $sheet->getRowDimension(3)->setRowHeight(2);
        $sheet->getRowDimension(7)->setRowHeight(2);
        $sheet->getRowDimension(10)->setRowHeight(2);
        $count = 1;

        $styles = [];
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
        for ($i = $this->start_row; $i <= sizeof($this->promotion->etudiants)+$this->start_row; $i++) {
            for($j = 0 ; $j < $this->header_size ; $j++){
                $styles[(chr(65+$j)."$i")]['borders'] = [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE
                    ],
                ];
            }
        }
        for ($i = 0; $i < $this->header_size; $i++) {
            $styles[chr(65 + $i)] = ['font' => ['size' => 15]];
            $styles[chr(65 + $i)]['alignment'] = [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,

            ];

        }

        $styles['A2'] = ['font' => ['size' => 14]];
        $styles['A4'] = ['font' => ['size' => 14, 'bold' => true]];
        $styles["8"] = ['font' => ['size'=> 17 ,'bold' => true]];
        $styles["$this->start_row"] = ['font' => [ 'bold' => true]];
        $styles["4"]['fill'] =[
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'color' => ['rgb' => 'd9d9d9']
        ];

        $styles["$this->start_row"]['fill'] =[
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'color' => ['rgb' => 'd9d9d9']
        ];


        return $styles;
    }
    public function startRow(): int
    {
        return $this->start_row;
    }
    public function startCell(): string
    {
        return "A$this->start_row";
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
        $widths[chr(70 + $i)] = 15;
        $widths[chr(70 + $i + 1)] = 15;
        $widths[chr(70 + $i + 2)] = 15;
        return $widths;
    }
    public function drawings()
    {
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath('images/ensa.png');
        $drawing->setHeight(81);
        $drawing->setCoordinates('A2');

        $drawing1 = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing1->setName('Logo');
        $drawing1->setDescription('This is my logo');
        $drawing1->setPath('images/usms.png');
        $drawing1->setHeight(81);
        $drawing1->setCoordinates(chr($this->header_size + 65 - 1) . "2");
        return [$drawing, $drawing1];
    }
    public function columnFormats(): array
    {
        $formats = [];
        for ($i = 0; $i < $this->header_size - 8; $i++) {
            $formats[chr(70 + $i)] = StyleNumberFormat::FORMAT_TEXT;

        }
        return $formats;
    }
}

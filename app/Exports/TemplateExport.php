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

abstract class TemplateExport implements WithColumnFormatting ,WithDrawings, WithCustomStartCell, WithStartRow, WithStyles
{
    private $title;
    private $sub_title;
    private $header_size;
    private $start_row ;
    public function __construct($title,$sub_title,$header_size,$start_row = 11)
    {
        $this->sub_title = $sub_title;
        $this->title = $title;
        $this->header_size = $header_size;
        $this->start_row = $start_row;
    }

    public abstract function additionalStyles(Worksheet $sheet,$styles);

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells("A2:" . chr($this->header_size + 65 - 1) . '2');
        $sheet->mergeCells("A4:" . chr($this->header_size + 65 - 1) . '6');
        $sheet->getCell('A2')->setValue("Université Sultan Moulay Slimane\nEcole Nationale des Sciences Appliquées Khouribga\nCentre de Formation Continue");

        $sheet->mergeCells("A8:" . chr($this->header_size + 65 - 1) . '9');
        $sheet->getCell('A8')->setValue($this->sub_title);

        $sheet->getStyle('A2')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setVertical('center');

        $sheet->getCell('A4')->setValue($this->title);
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

        $styles['A2'] = ['font' => ['size' => 14]];
        $styles['A4'] = ['font' => ['size' => 14, 'bold' => true]];
        $styles["8"] = ['font' => ['size'=> 17 ,'bold' => true]];
        $styles["$this->start_row"]['font'] = ['size'=>13, 'bold' => true];
        $styles["4"]['fill'] =[
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'color' => ['rgb' => 'd9d9d9']
        ];

        $styles["$this->start_row"]['fill'] =[
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'color' => ['rgb' => 'd9d9d9']
        ];
        for($i = 0 ; $i < $this->header_size ;$i++){
            $styles[chr(65+$i)."$this->start_row"]['borders']= [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ],
            ];
            $styles[chr(65+$i)]['alignment'] =  [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ];
        }

        $styles = $this->additionalStyles($sheet,$styles);

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

<?php

namespace App\Exports;

use App\Etudiant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Excel;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class EtudiantsExport implements FromCollection,WithMapping,WithEvents,WithStartRow,WithHeadings , WithCustomStartCell
{
    private $auto_incremental = 0;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Etudiant::all();
    }
    public function registerEvents():array
    {
        return [
            BeforeExport::class => function(BeforeExport $event){
                $event->writer->reopen(new \Maatwebsite\Excel\Files\LocalTemporaryFile(storage_path('app/public/templates/Skx7Wgp3Z3B75GzS3KkxUP9NdZrx7aPQmMyEwRmO.xlsx')),Excel::XLSX);
                $event->writer->getSheetByIndex(0);

                $this->calledByEvent = true; // set the flag
                $event->writer->getSheetByIndex(0)->export($event->getConcernable());

                $event->writer->getSheetByIndex(0)->getStyle('C11')->applyFromArray(array(
                    'fill' => array(
                        'type'  => Fill::FILL_SOLID,
                        'color' => array('rgb' => 'FF0000')
                    )
                ));
               return $event->getWriter()->getSheetByIndex(0);
            }
         ];
    }
    public function startRow(): int
    {
        return 16;
    }
    public function startCell(): string
    {
        return 'B16';
    }
    public function headings() : array {
        return [
            'Numéro',
            'Code Massar',
            'Nom',
            'Prénom',
            'CIN',
            'Date Naissance',
            'Email'
        ];
    }
    public function map($etudiant):array{
        $this->auto_incremental++;
        return [
            $this->auto_incremental,
            $etudiant->cne,
            $etudiant->first_name,
            $etudiant->last_name,
            $etudiant->cin,
            $etudiant->born_date,
            $etudiant->email
        ];
    }

    private function setBackground($sheet,$cellsColors){
        foreach($cellsColors as $cellcol){
                $sheet->getStyle($cellcol['cell'])->applyFromArray(array(
                    'fill' => array(
                        'type'  => Fill::FILL_SOLID,
                        'color' => array('rgb' => $cellcol['color'])
                    )
                ));
            }
    }
}

<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class ExportTest implements FromCollection,WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return new Collection();

    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                /** @var Sheet $sheet */
                $sheet = $event->sheet;

                /**
                 * validation for bulkuploadsheet
                 */
                $this->rowCount = 3;
                for($i=2; $i<=$this->rowCount+1; $i++){
                    $sheet->setCellValue('B'.$i, $sheet->getCell('B'.$i)->getValue());
                    $configs = "dis1, dis 2, dis 3";
                    $objValidation = $sheet->getCell('B'.$i)->getDataValidation();
                    $objValidation->setType(DataValidation::TYPE_LIST);
                    $objValidation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                    $objValidation->setAllowBlank(false);
                    $objValidation->setShowInputMessage(true);
                    $objValidation->setShowErrorMessage(true);
                    $objValidation->setShowDropDown(true);
                    $objValidation->setErrorTitle('Voulez vous crée un nouveau professeur');
                    $objValidation->setError('Value is not in list.');
                    $objValidation->setPromptTitle('Pick from list');
                    $objValidation->setPrompt('Please pick a rank from the drop-down list.');
                    $objValidation->setFormula1('"' . $configs . '"');
                }
            },
        ];
    }

}

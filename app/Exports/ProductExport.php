<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Lib\MyHelper;

class ProductExport implements FromArray,WithTitle,WithHeadings, ShouldAutoSize, WithEvents
{
	protected $data;
    protected $tab_title;

    public function __construct(array $data,$tab_title = 'List Products')
    {
        $this->data = $data;
        $this->tab_title = $tab_title;
    }

    public function headings():array
    {
        return array_keys($this->data[0]??[]);
    }

    /**
    * @return Array
    */
    public function array(): array
    {
        return $this->data;
    }
    /**
     * @return string
     */
    public function title(): string
    {
        return $this->tab_title;
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $last = count($this->data);
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ]
                    ],
                ];
                $styleHead = [
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'rotation' => 90,
                        'startColor' => [
                            'argb' => 'FFA0A0A0',
                        ],
                        'endColor' => [
                            'argb' => 'FFFFFFFF',
                        ],
                    ],
                ];
                $x_coor = MyHelper::getNameFromNumber(count($this->data[0]??[]));
                $event->sheet->getStyle('A1:'.$x_coor.($last+1))->applyFromArray($styleArray);
                $headRange = 'A1:'.$x_coor.'1';
                $event->sheet->getStyle($headRange)->applyFromArray($styleHead);
            },
        ];
    }
}
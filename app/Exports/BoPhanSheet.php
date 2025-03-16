<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class BoPhanSheet implements FromArray, WithTitle, WithEvents
{
    protected $boPhan;

    public function __construct($boPhan)
    {
        $this->boPhan = $boPhan;
    }

    public function array(): array
    {
        $result = [
            ['Mã bộ phận', 'Tên bộ phận'],
        ];

        foreach ($this->boPhan as $bp) {
            $result[] = [$bp['ma_bp'], $bp['ten_bp']];
        }

        return $result;
    }

    public function title(): string
    {
        return 'DM bộ phận';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = count($this->boPhan) + 1;

                foreach (range('A', 'F') as $col) {
                    $sheet->getColumnDimension($col)->setWidth(30);
                }

                $sheet->getStyle("A1:B$lastRow")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                        ],
                    ],
                ]);
            },
        ];
    }
}

<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class CongViecSheet implements FromArray, WithTitle, WithEvents
{
    protected $congViec;

    public function __construct($congViec)
    {
        $this->congViec = $congViec;
    }

    public function array(): array
    {
        $result = [
            ['Mã CV', 'Tên công việc', 'Mã bộ phận'],
        ];

        foreach ($this->congViec as $cv) {
            $result[] = [$cv['ma_cv'], $cv['ten_cv'], $cv['ma_bp']];
        }

        return $result;
    }

    public function title(): string
    {
        return 'Danh mục công việc';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $lastRow = count($this->congViec) + 1;

                foreach (range('A', 'F') as $col) {
                    $sheet->getColumnDimension($col)->setWidth(30);
                }

                $sheet->getStyle("A1:C$lastRow")->applyFromArray([
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

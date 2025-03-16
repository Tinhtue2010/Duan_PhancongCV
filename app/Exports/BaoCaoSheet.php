<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class BaoCaoSheet implements FromArray, WithTitle, WithEvents
{
    protected $baoCao;

    public function __construct($baoCao)
    {
        $this->baoCao = $baoCao;
    }

    public function array(): array
    {
        $result = [
            ['Mã BC', 'Bộ phận công tác thực hiện', 'Tên báo cáo', 'Thời hạn báo cáo', 'Thời gian có hiệu lực', 'Nơi nhận'],
        ];

        foreach ($this->baoCao as $bc) {
            $result[] = [
                $bc['ma_bc'], 
                $bc['bo_phan_thuc_hien'], 
                $bc['ten_bc'], 
                $bc['thoi_han'], 
                $bc['hieu_luc'], 
                $bc['noi_nhan']
            ];
        }

        return $result;
    }

    public function title(): string
    {
        return 'Danh mục báo cáo';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $lastRow = count($this->baoCao) + 1;

                foreach (range('A', 'F') as $col) {
                    $sheet->getColumnDimension($col)->setWidth(30);
                }

                $sheet->getStyle("A1:F$lastRow")->applyFromArray([
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

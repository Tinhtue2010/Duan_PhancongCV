<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class DanhSachCanBoSheet implements FromArray, WithTitle, WithEvents
{
    protected $danhSachCanBo;

    public function __construct($danhSachCanBo)
    {
        $this->danhSachCanBo = $danhSachCanBo;
    }

    public function array(): array
    {
        $result = [
            ['Mã CC', 'Họ và tên', 'Chức danh', 'Bộ phận công tác', 'Trạng thái'],
        ];

        foreach ($this->danhSachCanBo as $canBo) {
            $result[] = [
                $canBo['ma_cc'], 
                $canBo['ho_ten'], 
                $canBo['chuc_danh'], 
                $canBo['bo_phan'], 
                $canBo['trang_thai']
            ];
        }

        return $result;
    }

    public function title(): string
    {
        return 'Danh sach CBCC';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = count($this->danhSachCanBo) + 1;

                foreach (range('A', 'F') as $col) {
                    $sheet->getColumnDimension($col)->setWidth(30);
                }

                $sheet->getStyle("A1:E$lastRow")->applyFromArray([
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

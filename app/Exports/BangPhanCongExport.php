<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use Carbon\Carbon;

class BangPhanCongExport implements FromArray, WithEvents
{
    protected $danhSachCanBo;

    public function __construct($danhSachCanBo)
    {
        $this->danhSachCanBo = $danhSachCanBo;
    }

    public function array(): array
    {
        $currentDate = Carbon::now()->format('d');
        $currentMonth = Carbon::now()->format('m');
        $currentYear = Carbon::now()->format('Y');

        $result = [
            ['CHI CỤC HẢI QUAN KHU VỰC VIII'],
            ['HẢI QUAN CỬA KHẨU VẠN GIA'],
            ['BẢNG PHÂN CÔNG NHIỆM VỤ CHO CÁN BỘ CÔNG CHỨC, NGƯỜI LAO ĐỘNG'],
            ["(Ngày $currentDate tháng $currentMonth năm $currentYear)"],
            ['', ''],
            ['','Tổng số CBCC, người lao động: Tổng số CBCC theo danh sách'],
            ['','Vắng mặt: VD 03 đ/c (Nghỉ ốm 1, nghỉ phép 1, đi công tác 1…)'],
            ['', ''],
            ['NỘI DUNG PHÂN CÔNG CHI TIẾT NHƯ SAU:'],
            ['STT', 'Họ và tên', 'Chức vụ/ Bộ phận công tác', 'Nội dung công việc được phân công'],
        ];

        $stt = 1;
        foreach ($this->danhSachCanBo as $canBo) {
            $result[] = [
                $stt++, 
                $canBo['ho_ten'], 
                $canBo['chuc_vu'], 
                $canBo['noi_dung_cong_viec']
            ];
        }
        
        $result[] = ['', ''];
        $result[] = ['','Lập biểu', '', 'THỦ TRƯỞNG ĐƠN VỊ'];
        $result[] = ['', '','', '(Ký, ghi rõ họ tên)'];

        return $result;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $sheet->getDelegate()->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
                
                $countHeight = count($this->danhSachCanBo)+10;

                $sheet->getDelegate()->getStyle("A10:D10")->applyFromArray([
                    'font' => ['bold' => true],
                ]);

                $sheet->getDelegate()->getStyle("A10:D".$countHeight)->applyFromArray([
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
                ]);
                $sheet->getDelegate()->getStyle("D10:D".$countHeight)->getAlignment()->setWrapText(true);


                $sheet->getDelegate()->getColumnDimension('B')->setWidth(30);
                $sheet->getDelegate()->getColumnDimension('C')->setWidth(30);
                $sheet->getDelegate()->getColumnDimension('D')->setWidth(30);


                $sheet->getDelegate()->mergeCells('A1:C1');
                $sheet->getDelegate()->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

                $sheet->getDelegate()->mergeCells('A2:C2');
                $sheet->getDelegate()->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);


                $sheet->getDelegate()->mergeCells('A3:D3');
                $sheet->getDelegate()->mergeCells('A4:D4');
                $sheet->getDelegate()->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->getDelegate()->getStyle('A4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->getDelegate()->getStyle('A'.($countHeight+1).':D'.($countHeight+3))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            }
        ];
    }
}

<?php

namespace App\Http\Controllers;

use App\Exports\BangPhanCongExport;
use App\Exports\MainExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DemoController extends Controller
{
    // Demo tạo file excel phân công công việc
    public function index()
    {
        $danhSachCanBo = [
            ['ho_ten' => 'Nguyễn Văn A', 'chuc_vu' => 'Kiểm tra giám sát', 'noi_dung_cong_viec' => "- Báo cáo theo công văn số...\n- Kiểm tra, giám sát hàng..."],
            ['ho_ten' => 'Trần Thị B', 'chuc_vu' => 'Hành chính', 'noi_dung_cong_viec' => "- Xử lý hồ sơ nhập khẩu\n- Báo cáo định kỳ"],
            // Thêm dữ liệu khác tại đây
        ];

        return Excel::download(new BangPhanCongExport($danhSachCanBo), 'BangPhanCong.xlsx');
    }

    function demo2() {
        $danhSachCanBo = [
            ['ma_cc' => 'HQ001', 'ho_ten' => 'Nguyễn Văn A', 'chuc_danh' => 'Chức danh A', 'bo_phan' => 'Bộ phận 1', 'trang_thai' => 'Đang làm việc'],
            ['ma_cc' => 'HQ002', 'ho_ten' => 'Trần Thị B', 'chuc_danh' => 'Chức danh B', 'bo_phan' => 'Bộ phận 2', 'trang_thai' => 'Nghỉ phép'],
        ];
    
        $boPhan = [
            ['ma_bp' => 'BP001', 'ten_bp' => 'Đội trưởng'],
            ['ma_bp' => 'BP002', 'ten_bp' => 'Phó đội trưởng'],
        ];
    
        $baoCao = [
            [
                'ma_bc' => 'BC01',
                'bo_phan_thuc_hien' => 'Bộ phận tổng hợp',
                'ten_bc' => 'Báo cáo tháng',
                'thoi_han' => 'Trước ngày 15 hàng tháng',
                'hieu_luc' => '',
                'noi_nhan' => 'VP Cục',
            ],
        ];
        
    
        $congViec = [
            [
                'ma_cv' => 'CV001',
                'ten_cv' => 'Kiểm tra hàng hóa',
                'ma_bp'  => 'BP001',
            ],
            [
                'ma_cv' => 'CV002',
                'ten_cv' => 'Giám sát nhập hàng',
                'ma_bp'  => 'BP002',
            ],
        ];
        
    
        return Excel::download(new MainExport($danhSachCanBo, $boPhan, $baoCao, $congViec), 'DanhSach.xlsx');
    }
}

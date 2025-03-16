<?php

namespace App\Http\Controllers;

use App\Exports\BangPhanCongExport;
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
}

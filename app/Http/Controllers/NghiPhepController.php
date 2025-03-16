<?php

namespace App\Http\Controllers;

use App\Models\BoPhan;
use App\Models\CanBo;
use App\Models\NghiPhep;
use App\Models\TaiKhoan;
use Illuminate\Http\Request;

class NghiPhepController extends Controller
{
    function index()
    {
        $data = NghiPhep::leftJoin('can_bo','can_bo.ma_can_bo','=','nghi_phep.ma_can_bo')->get();
        $a = CanBo::leftJoin('tai_khoan', 'can_bo.ma_tai_khoan', '=', 'tai_khoan.ma_tai_khoan')
            ->orderBy('ma_can_bo', 'desc')->get();

        $taiKhoans = TaiKhoan::where('quyen_han', 'Cán bộ')
            ->doesntHave('canBo')
            ->get();
        $boPhans = BoPhan::all();

        return view('quan-ly-khac.danh-sach-nghi-phep', data: compact('data', 'taiKhoans', 'boPhans'));
    }
}

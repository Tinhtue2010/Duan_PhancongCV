<?php

namespace App\Http\Controllers;

use App\Models\BoPhan;
use App\Models\CanBo;
use App\Models\NghiPhep;
use App\Models\TaiKhoan;
use Illuminate\Http\Request;

class NghiPhepController extends Controller
{
    function danhSachNghiPhep()
    {
        $data = NghiPhep::leftJoin('can_bo','can_bo.ma_can_bo','=','nghi_phep.ma_can_bo')
        ->orderBy('ngay_bat_dau', 'desc')->get();
        $a = CanBo::leftJoin('tai_khoan', 'can_bo.ma_tai_khoan', '=', 'tai_khoan.ma_tai_khoan')
            ->orderBy('ma_can_bo', 'desc')->get();
        $danhSachCanBo = CanBo::get();

        $taiKhoans = TaiKhoan::where('quyen_han', 'Cán bộ')
            ->doesntHave('canBo')
            ->get();
        $boPhans = BoPhan::all();
        return view('danh-sach-nghi-phep', data: compact('data', 'taiKhoans', 'boPhans','danhSachCanBo'));
    }

    function themNghiPhep(Request $request) {
        $request->validate([
            'ma_can_bo' => 'required|string|max:50',
            'ngay_lam_viec' => 'nullable|date',
            'tu_gio' => 'nullable|string',
            'den_gio' => 'nullable|string',
            'ngay_bat_dau' => 'required|date',
            'ngay_ket_thuc' => 'required|date|after_or_equal:ngay_bat_dau',
            'ly_do_vang' => 'nullable|string|max:255',
        ]);

        NghiPhep::create([
            'ma_can_bo' => $request->ma_can_bo,
            'ngay_lam_viec' => $request->ngay_lam_viec,
            'tu_gio' => $request->tu_gio,
            'den_gio' => $request->den_gio,
            'ngay_bat_dau' => $request->ngay_bat_dau,
            'ngay_ket_thuc' => $request->ngay_ket_thuc,
            'ly_do_vang' => $request->ly_do_vang,
        ]);

        return redirect()->back()->with('success', 'Đã lưu thông tin nghỉ phép!');
    }

    function updateNghiPhep(Request $request) {
        $request->validate([
            'ma_can_bo' => 'required|string|max:50',
            'ngay_lam_viec' => 'nullable|date',
            'tu_gio' => 'nullable|string',
            'den_gio' => 'nullable|string',
            'ngay_bat_dau' => 'required|date',
            'ngay_ket_thuc' => 'required|date|after_or_equal:ngay_bat_dau',
            'ly_do_vang' => 'nullable|string|max:255',
        ]);
    
        $nghiPhep = NghiPhep::where('ma_nghi_phep', $request->ma_nghi_phep)->first();
        
        $nghiPhep->update([
            'ma_can_bo' => $request->ma_can_bo,
            'ngay_lam_viec' => $request->ngay_lam_viec,
            'tu_gio' => $request->tu_gio,
            'den_gio' => $request->den_gio,
            'ngay_bat_dau' => $request->ngay_bat_dau,
            'ngay_ket_thuc' => $request->ngay_ket_thuc,
            'ly_do_vang' => $request->ly_do_vang,
        ]);
    
        return redirect()->back()->with('success', 'Đã cập nhật thông tin nghỉ phép!');
    }
    

    function xoaNghiPhep(Request $request) {
        NghiPhep::where('ma_nghi_phep', $request->ma_nghi_phep)->delete();
        session()->flash('alert-success', 'Xóa nghỉ phép thành công');
        return redirect()->back();
    }
}

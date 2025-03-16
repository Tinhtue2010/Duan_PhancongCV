<?php

namespace App\Http\Controllers;

use App\Models\BoPhan;
use App\Models\CanBo;
use App\Models\PhanQuyenBaoCao;
use App\Models\TaiKhoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class CanBoController extends Controller
{
    public function danhSachCanBo()
    {
        $data = CanBo::leftJoin('tai_khoan', 'can_bo.ma_tai_khoan', '=', 'tai_khoan.ma_tai_khoan')
            ->get();

        $taiKhoans = TaiKhoan::where('loai_tai_khoan', 'Cán bộ')
            ->doesntHave('canBo')
            ->get();
        $boPhans = BoPhan::all();

        return view('quan-ly-khac.danh-sach-can-bo', data: compact('data', 'taiKhoans', 'boPhans'));
    }

    public function themCanBo(Request $request)
    {
        if (CanBo::find($request->ma_can_bo)) {
            session()->flash('alert-danger', 'Mã cán bộ này đã tồn tại.');
            return redirect()->back();
        }
        $ma_tai_khoan = $this->taoTaiKhoan($request->ten_dang_nhap, $request->mat_khau, "Cán bộ");
        if (!$ma_tai_khoan) {
            session()->flash('alert-danger', 'Tên đăng nhập này đã được sử dụng.');
            return redirect()->back();
        }
        CanBo::create([
            'ten_can_bo' => $request->ten_can_bo,
            'ngay_sinh' => $request->ngay_sinh,
            'trinh_do' => $request->trinh_do,
            'chuyen_mon' => $request->chuyen_mon,
            'chuc_danh' => $request->chuc_danh,
            'ngay_tuyen_dung' => $request->ngay_tuyen_dung,
            'trang_thai' => $request->trang_thai,
            'ma_bo_phan' => $request->ma_bo_phan,
        ]);
        session()->flash('alert-success', 'Thêm cán bộ mới thành công');
        return redirect()->back();
    }
    public function taoTaiKhoan($ten_dang_nhap, $mat_khau, $loai_tai_khoan)
    {
        if (!TaiKhoan::where('ten_dang_nhap', $ten_dang_nhap)->get()->isEmpty()) {
            return false;
        }
        $taiKhoan = TaiKhoan::create([
            'ten_dang_nhap' => $ten_dang_nhap,
            'mat_khau' => Hash::make($mat_khau),
            'loai_tai_khoan' => $loai_tai_khoan,
        ]);
        return $taiKhoan->ma_tai_khoan;
    }
    public function xoaCanBo(Request $request)
    {
        CanBo::find($request->ma_can_bo)->delete();
        session()->flash('alert-success', 'Xóa công chức thành công');
        return redirect()->back();
    }

    public function updateCanBo(Request $request)
    {
        $canBo = CanBo::find($request->ma_can_bo);
        $ma_can_bo = $request->ma_can_bo;
        if ($canBo) {
            $canBo->update([
                'ten_can_bo' => $request->ten_can_bo,
                'ngay_sinh' => \Carbon\Carbon::createFromFormat('d/m/Y', $request->ngay_sinh)->format('Y-m-d'),
                'trinh_do' => $request->trinh_do,
                'chuyen_mon' => $request->chuyen_mon,
                'chuc_danh' => $request->chuc_danh,
                'ngay_tuyen_dung' => \Carbon\Carbon::createFromFormat('d/m/Y', $request->ngay_tuyen_dung)->format('Y-m-d'),
                'trang_thai' => $request->trang_thai,
                'ma_bo_phan' => $request->ma_bo_phan,
            ]);

            if ($request->ma_tai_khoan != '') {
                $taiKhoan =  TaiKhoan::find($request->ma_tai_khoan);
                CanBo::find($ma_can_bo)->update(['ma_tai_khoan' => $taiKhoan->ma_tai_khoan]);;
            }

            $canBo->save();
            session()->flash('alert-success', 'Cập nhật thành công');
            return redirect()->back();
        } else {
            session()->flash('alert-danger', 'Có lỗi xảy ra');
            return redirect()->back();
        }
    }
}

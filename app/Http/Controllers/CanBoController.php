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
            ->orderBy('ma_can_bo', 'desc')->get();

        $taiKhoans = TaiKhoan::where('quyen_han', 'Cán bộ')
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
        $ma_tai_khoan = $this->taoTaiKhoan($request->ten_dang_nhap, $request->mat_khau, $request->quyen_han);
        if (!$ma_tai_khoan) {
            session()->flash('alert-danger', 'Tên đăng nhập này đã được sử dụng.');
            return redirect()->back();
        }
        CanBo::create([
            'ten_can_bo' => $request->ten_can_bo,
            'chuc_danh' => $request->chuc_danh,
            'nhom_vi_tri_lam_viec' => $request->nhom_vi_tri_lam_viec,
            'trang_thai' => $request->trang_thai,
            'ma_bo_phan' => $request->ma_bo_phan,
            'ma_tai_khoan' => $ma_tai_khoan,
        ]);
        session()->flash('alert-success', 'Thêm cán bộ mới thành công');
        return redirect()->back();
    }
    public function taoTaiKhoan($ten_dang_nhap, $mat_khau, $quyen_han)
    {
        if (!TaiKhoan::where('ten_dang_nhap', $ten_dang_nhap)->get()->isEmpty()) {
            return false;
        }
        $taiKhoan = TaiKhoan::create([
            'ten_dang_nhap' => $ten_dang_nhap,
            'mat_khau' => Hash::make($mat_khau),
            'quyen_han' => $quyen_han,
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
                'chuc_danh' => $request->chuc_danh,
                'trang_thai' => $request->trang_thai,
                'ma_bo_phan' => $request->ma_bo_phan,
                'nhom_vi_tri_lam_viec' => $request->nhom_vi_tri_lam_viec,
            ]);

            if ($request->ma_tai_khoan != '') {
                TaiKhoan::find($request->ma_tai_khoan)->update([
                    'quyen_han' => $request->quyen_han,
                ]);
                CanBo::find($ma_can_bo)->update(
                    [
                        'ma_tai_khoan' => $request->ma_tai_khoan,
                    ]
                );;
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

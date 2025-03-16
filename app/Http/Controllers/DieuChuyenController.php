<?php

namespace App\Http\Controllers;

use App\Models\BoPhan;
use App\Models\CanBo;
use App\Models\DieuChuyen;
use App\Models\PhanQuyenBaoCao;
use App\Models\TaiKhoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class DieuChuyenController extends Controller
{
    public function danhSachDieuChuyen()
    {
        $data = DieuChuyen::join('can_bo', 'can_bo.ma_can_bo', '=', 'dieu_chuyen.ma_can_bo')
            ->join('bo_phan', 'bo_phan.ma_bo_phan', '=', 'dieu_chuyen.ma_bo_phan_chuyen_den')
            ->orderBy('ma_dieu_chuyen', 'desc')
            ->get();
        $canBos = CanBo::where('trang_thai', 1)->get();
        $boPhans = BoPhan::where('trang_thai', 1)->get();
        return view('quan-ly-khac.danh-sach-dieu-chuyen', data: compact('data', 'canBos', 'boPhans'));
    }

    public function themDieuChuyen(Request $request)
    {
        $canBo = CanBo::find($request->ma_can_bo);
        if ($request->ly_do == "Điều chuyển bộ phận") {
            $canBo->update([
                'ma_bo_phan' => $request->ma_bo_phan_chuyen_den,
                'chuc_danh' => $request->chuc_danh_moi
            ]);
        } else {
            $canBo->update([
                'trang_thai' => 0,
            ]);
        }

        DieuChuyen::create([
            'ma_dieu_chuyen' => $request->ma_dieu_chuyen,
            'ma_can_bo' => $request->ma_can_bo,
            'thoi_gian_dieu_chuyen' => $request->thoi_gian_dieu_chuyen,
            'ma_bo_phan_chuyen_den' => $request->ma_bo_phan_chuyen_den,
            'chuc_danh_moi' => $request->chuc_danh_moi,
            'ly_do' => $request->ly_do,
        ]);


        session()->flash('alert-success', 'Thêm điều chuyển mới thành công');
        return redirect()->back();
    }
    public function xoaDieuChuyen(Request $request)
    {
        DieuChuyen::find($request->ma_dieu_chuyen)->delete();
        session()->flash('alert-success', 'Xóa điều chuyển thành công');
        return redirect()->back();
    }

    public function updateDieuChuyen(Request $request)
    {
        $dieuChuyen = DieuChuyen::find($request->ma_dieu_chuyen);
        if ($dieuChuyen) {
            $dieuChuyen->update([
                'ma_dieu_chuyen' => $request->ma_dieu_chuyen,
                'ma_can_bo' => $request->ma_can_bo,
                'thoi_gian_dieu_chuyen' => $request->thoi_gian_dieu_chuyen,
                'ma_bo_phan_chuyen_den' => $request->ma_bo_phan_chuyen_den,
                'chuc_danh_moi' => $request->chuc_danh_moi,
                'ly_do' => $request->ly_do,
            ]);

            $dieuChuyen->save();
            session()->flash('alert-success', 'Cập nhật thành công');
            return redirect()->back();
        } else {
            session()->flash('alert-danger', 'Có lỗi xảy ra');
            return redirect()->back();
        }
    }
}

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
        $data = BoPhan::orderBy('ma_bo_phan', 'desc')->get();
        return view('quan-ly-khac.danh-sach-bo-phan', data: compact( 'data'));
    }

    public function themDieuChuyen(Request $request)
    {
        DieuChuyen::create([
            'ma_dieu_chuyen' => $request->ma_dieu_chuyen,
            'ma_can_bo'=> $request->ma_can_bo,
            'thoi_gian_dieu_chuyen'=> $request->thoi_gian_dieu_chuyen,
            'ma_bo_phan_chuyen_den'=> $request->ma_bo_phan_chuyen_den,
            'chuc_danh_moi'=> $request->chuc_danh_moi,
            'ly_do'=> $request->ly_do,
        ]);
        session()->flash('alert-success', 'Thêm bộ phận mới thành công');
        return redirect()->back();
    }
    public function xoaDieuChuyen(Request $request)
    {
        BoPhan::find($request->ma_bo_phan)->delete();
        session()->flash('alert-success', 'Xóa bộ phận thành công');
        return redirect()->back();
    }

    public function updateDieuChuyen(Request $request)
    {
        $boPhan = BoPhan::find($request->ma_bo_phan);
        if ($boPhan) {
            $boPhan->update([
                'ten_bo_phan' => $request->ten_bo_phan,
                'chuc_nang_nhiem_vu' => $request->chuc_nang_nhiem_vu,
                'thoi_gian_thanh_lap' => $request->thoi_gian_thanh_lap ? \Carbon\Carbon::createFromFormat('d/m/Y', $request->thoi_gian_thanh_lap)->format('Y-m-d') : '',
                'thoi_gian_giai_the' => $request->thoi_gian_giai_the ? \Carbon\Carbon::createFromFormat('d/m/Y', $request->thoi_gian_giai_the)->format('Y-m-d') : '',
                'trang_thai' => $request->trang_thai,
            ]);

            $boPhan->save();
            session()->flash('alert-success', 'Cập nhật thành công');
            return redirect()->back();
        } else {
            session()->flash('alert-danger', 'Có lỗi xảy ra');
            return redirect()->back();
        }
    }
}

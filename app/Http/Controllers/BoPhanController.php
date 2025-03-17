<?php

namespace App\Http\Controllers;

use App\Models\BoPhan;
use App\Models\CanBo;
use App\Models\PhanQuyenBaoCao;
use App\Models\TaiKhoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class BoPhanController extends Controller
{
    public function danhSachBoPhan()
    {
        $data = BoPhan::orderBy('ma_bo_phan', 'desc')->get();
        return view('bo-phan.danh-sach-bo-phan', data: compact('data'));
    }
    public function canBoCuaBoPhan(Request $request)
    {
        $boPhan = BoPhan::find($request->ma_bo_phan);
        $data = CanBo::where('ma_bo_phan', $request->ma_bo_phan)->join('tai_khoan', 'can_bo.ma_tai_khoan', '=', 'tai_khoan.ma_tai_khoan')
            ->where('trang_thai', 1)->get();
        $taiKhoans = TaiKhoan::where('quyen_han', 'Cán bộ')
            ->doesntHave('canBo')
            ->get();
        $boPhans = BoPhan::all();
        return view('bo-phan.can-bo-cua-bo-phan', data: compact('data', 'taiKhoans', 'boPhans', 'boPhan'));
    }

    public function themBoPhan(Request $request)
    {
        BoPhan::create([
            'ten_bo_phan' => $request->ten_bo_phan,
            'chuc_nang_nhiem_vu' => $request->chuc_nang_nhiem_vu,
            'thoi_gian_thanh_lap' => $request->thoi_gian_thanh_lap ? \Carbon\Carbon::createFromFormat('d/m/Y', $request->thoi_gian_thanh_lap)->format('Y-m-d') : '',
            'thoi_gian_giai_the' => $request->thoi_gian_giai_the ? \Carbon\Carbon::createFromFormat('d/m/Y', $request->thoi_gian_giai_the)->format('Y-m-d') : '',
            'trang_thai' => $request->trang_thai,
        ]);
        session()->flash('alert-success', 'Thêm bộ phận mới thành công');
        return redirect()->back();
    }
    public function xoaBoPhan(Request $request)
    {
        $boPhan = BoPhan::where('bo_phan.ma_bo_phan', $request->ma_bo_phan)
            ->join('can_bo', 'can_bo.ma_bo_phan', 'bo_phan.ma_bo_phan')
            ->get();
        if ($boPhan->isNotEmpty()) {
            session()->flash('alert-danger', 'Bộ phận này vẫn còn công chức ở trong');
            return redirect()->back();
        } else {
            BoPhan::find($request->ma_bo_phan)->delete();
            session()->flash('alert-success', 'Xóa bộ phận thành công');
            return redirect()->back();
        }
    }

    public function updateBoPhan(Request $request)
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

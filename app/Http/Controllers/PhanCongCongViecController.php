<?php

namespace App\Http\Controllers;

use App\Models\BoPhan;
use App\Models\CanBo;
use App\Models\CongViec;
use App\Models\PhanCong;
use App\Models\PhanQuyenBaoCao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class PhanCongCongViecController extends Controller
{
    public function danhSachPhanCong()
    {
        $canBo = CanBo::where('ma_tai_khoan',Auth::user()->ma_tai_khoan)->first();
        $data = PhanCong::join('cong_viec', 'cong_viec.ma_cong_viec', '=', 'phan_cong.ma_cong_viec')
            ->join('can_bo as giao', 'giao.ma_can_bo', '=', 'phan_cong.ma_can_bo_giao')
            ->join('can_bo as nhan', 'nhan.ma_can_bo', '=', 'phan_cong.ma_can_bo_nhan')
            ->orderBy('ma_phan_cong', 'desc')
            ->select(
                'phan_cong.*',
                'cong_viec.ten_cong_viec',
                'giao.ten_can_bo as ten_can_bo_giao',
                'nhan.ten_can_bo as ten_can_bo_nhan' 
            )
            ->get();
        $boPhans = BoPhan::all();
        if(Auth::user()->quyen_han === 'CBQL2'){
            $canBos = CanBo::where('trang_thai', 1)->where('ma_bo_phan',$canBo->ma_bo_phan)->get();
        } else {
            $canBos = [];
        }


        $congViecs = CongViec::where('trang_thai', 1)->get();

        return view('danh-sach-phan-cong', data: compact('data', 'canBos', 'congViecs','boPhans'));
    }

    public function themPhanCong(Request $request)
    {
        PhanCong::create([
            'ma_cong_viec' => $request->ma_cong_viec,
            'ma_can_bo_giao' => $request->ma_can_bo_giao,
            'ma_can_bo_nhan' => $request->ma_can_bo_nhan,
            'ngay_phan_cong' => now(),
            'ngay_nhan_viec' => $request->ngay_nhan_viec ? \Carbon\Carbon::createFromFormat('d/m/Y', $request->ngay_nhan_viec)->format('Y-m-d') : '',
            'chi_tiet' => $request->chi_tiet,
        ]);

        session()->flash('alert-success', 'Thêm phân công mới thành công');
        return redirect()->back();
    }
    public function xoaPhanCong(Request $request)
    {
        PhanCong::find($request->ma_phan_cong)->update(['trang_thai' => 0]);
        session()->flash('alert-success', 'Xóa phân công thành công');
        return redirect()->back();
    }

    public function updatePhanCong(Request $request)
    {
        $phanCong = PhanCong::find($request->ma_phan_cong);
        if ($phanCong) {
            $phanCong->update([
                'ma_cong_viec' => $request->ma_cong_viec,
                'chi_tiet' => $request->chi_tiet,
                'ngay_nhan_viec' => $request->ngay_nhan_viec ? \Carbon\Carbon::createFromFormat('d/m/Y', $request->ngay_nhan_viec)->format('Y-m-d') : ''
            ]);

            $phanCong->save();
            session()->flash('alert-success', 'Cập nhật thành công');
            return redirect()->back();
        } else {
            session()->flash('alert-danger', 'Có lỗi xảy ra');
            return redirect()->back();
        }
    }

    public function getCongViec(Request $request)
    {
        $congViecs = CongViec::where('loai_cong_viec', $request->loaiCongViec)->get();

        return response()->json([
            'congViecs' => $congViecs
        ]);
    }
    public function getCanBo(Request $request)
    {
        $canBos = CanBo::where('ma_bo_phan', $request->ma_bo_phan)->get();

        return response()->json([
            'canBos' => $canBos
        ]);
    }
}

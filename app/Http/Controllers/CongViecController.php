<?php

namespace App\Http\Controllers;

use App\Models\BoPhan;
use App\Models\CongViec;
use App\Models\CanBo;
use App\Models\PhanQuyenBaoCao;
use App\Models\TaiKhoan;
use App\Models\ThoiHanHoanThanh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class CongViecController extends Controller
{
    public function danhSachCongViec()
    {
        $data = CongViec::join('thoi_han_hoan_thanh', 'thoi_han_hoan_thanh.ma_cong_viec', '=', 'cong_viec.ma_cong_viec')
            ->join('bo_phan', 'bo_phan.ma_bo_phan', 'cong_viec.ma_bo_phan')
            ->orderBy('cong_viec.ma_cong_viec', 'desc')
            ->select('cong_viec.*', 'bo_phan.ten_bo_phan')
            ->get();
        return view('cong-viec.danh-sach-cong-viec', data: compact('data'));
    }
    public function themCongViec()
    {
        $boPhans = BoPhan::where('trang_thai', 1)->get();
        return view('cong-viec.them-cong-viec', data: compact('boPhans'));
    }
    public function themCongViecSubmit(Request $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $congViec = CongViec::create([
                    'ten_cong_viec' => $request->ten_cong_viec,
                    'ma_bo_phan' => $request->ma_bo_phan,
                    'loai_cong_viec' => $request->loai_cong_viec,
                    'noi_nhan' => $request->noi_nhan,
                    'trang_thai' => 1,
                ]);
                $rowsData = json_decode($request->rows_data, true);
                foreach ($rowsData as $row) {
                    ThoiHanHoanThanh::create([
                        'ma_cong_viec' => $congViec->ma_cong_viec,
                        'moc_thoi_gian' => $row['moc_thoi_gian'],
                        'ngay_het_han' => $row['ngay_het_han'],
                        'thang_het_han' => $row['thang_het_han'],
                    ]);
                }

                session()->flash('alert-success', 'Thêm công việc mới thành công');
                return redirect()->route('cong-viec.danh-sach-cong-viec');           
            });
        } catch (\Exception $e) {
            Log::error('Error in themCongViecSubmit: ' . $e->getMessage());
            session()->flash('alert-danger', 'Có lỗi xảy ra trong hệ thống');
            return redirect()->back();
        }
    }

    public function suaCongViec($ma_cong_viec)
    {
        $boPhans = BoPhan::where('trang_thai', 1)->get();
        $congViec = CongViec::find($ma_cong_viec);
        $loaiCongViecs = ['Nghiệp vụ','Báo cáo','Văn bản'];
        $thoiHanRows = ThoiHanHoanThanh::where('ma_cong_viec',$ma_cong_viec)->get();
        return view('cong-viec.sua-cong-viec', data: compact('boPhans', 'congViec','loaiCongViecs','thoiHanRows'));
    }
    public function suaCongViecSubmit(Request $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $congViec = CongViec::find($request->ma_cong_viec);
                $congViec->update([
                    'ten_cong_viec' => $request->ten_cong_viec,
                    'ma_bo_phan' => $request->ma_bo_phan,
                    'loai_cong_viec' => $request->loai_cong_viec,
                    'noi_nhan' => $request->noi_nhan,
                    'trang_thai' => 1,
                ]);

                ThoiHanHoanThanh::where('ma_cong_viec',$request->ma_cong_viec)->delete();
                $rowsData = json_decode($request->rows_data, true);
                foreach ($rowsData as $row) {
                    ThoiHanHoanThanh::create([
                        'ma_cong_viec' => $congViec->ma_cong_viec,
                        'moc_thoi_gian' => $row['moc_thoi_gian'],
                        'ngay_het_han' => $row['ngay_het_han'],
                        'thang_het_han' => $row['thang_het_han'],
                    ]);
                }

                session()->flash('alert-success', 'Thêm công việc mới thành công');
                return redirect()
                    ->route('cong-viec.danh-sach-cong-viec')
                    ->with('alert-success', 'Sửa công việc thành công!');            
                });
        } catch (\Exception $e) {
            Log::error('Error in themCongViecSubmit: ' . $e->getMessage());
            session()->flash('alert-danger', 'Có lỗi xảy ra trong hệ thống');
            return redirect()->back();
        }
    }


    public function xoaCongViec(Request $request)
    {
        CongViec::find($request->ma_cong_viec)->update([
            'trang_thai' => 0
        ]);
        session()->flash('alert-success', 'Hủy công việc thành công');
        return redirect()->back();
    }
    public function kichHoatCongViec(Request $request)
    {
        CongViec::find($request->ma_cong_viec)->update([
            'trang_thai' => 1
        ]);
        session()->flash('alert-success', 'Kích hoạt công việc thành công');
        return redirect()->back();
    }

    public function updateCongViec(Request $request)
    {
        $CongViec = CongViec::find($request->ma_bo_phan);
        if ($CongViec) {
            $CongViec->update([
                'ten_bo_phan' => $request->ten_bo_phan,
                'chuc_nang_nhiem_vu' => $request->chuc_nang_nhiem_vu,
                'thoi_gian_thanh_lap' => $request->thoi_gian_thanh_lap ? \Carbon\Carbon::createFromFormat('d/m/Y', $request->thoi_gian_thanh_lap)->format('Y-m-d') : '',
                'thoi_gian_giai_the' => $request->thoi_gian_giai_the ? \Carbon\Carbon::createFromFormat('d/m/Y', $request->thoi_gian_giai_the)->format('Y-m-d') : '',
                'trang_thai' => $request->trang_thai,
            ]);

            $CongViec->save();
            session()->flash('alert-success', 'Cập nhật thành công');
            return redirect()->back();
        } else {
            session()->flash('alert-danger', 'Có lỗi xảy ra');
            return redirect()->back();
        }
    }
}

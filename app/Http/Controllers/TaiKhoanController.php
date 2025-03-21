<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CanBo;
use App\Models\TaiKhoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TaiKhoanController extends Controller
{
    public function dangNhap()
    {
        return view('dang-nhap');
    }

    public function submitDangNhap(Request $request)
    {
        $credentials = $request->validate([
            'ten_dang_nhap' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->quyen_han != "Admin") {
                if (!CanBo::where('ma_tai_khoan', Auth::user()->ma_tai_khoan)->first()) {
                    session()->flash('alert-danger', 'Tài khoản này chưa được gán cho cán bộ nào');
                    return redirect()->back();
                }
                return redirect()->route('bo-phan.danh-sach-bo-phan');
            } elseif ($user->quyen_han == "Admin") {
                return redirect()->route('can-bo.danh-sach-can-bo');
            }
        }
        session()->flash('alert-danger', 'Tên đăng nhập hoặc tài khoản không đúng');
        return back();
    }

    public function dangXuat(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function danhSachTaiKhoan()
    {
        $data = TaiKhoan::orderBy('ma_tai_khoan', 'desc')->get();
        return view('danh-sach-tai-khoan', data: compact(var_name: 'data'));
    }

    public function themTaiKhoan(Request $request)
    {
        if (!TaiKhoan::where('ten_dang_nhap', $request->ten_dang_nhap)->get()->isEmpty()) {
            session()->flash('alert-danger', 'Tên đăng nhập này đã tồn tại.');
            return redirect()->back();
        }
        if ($request->quyen_han == 'Công chức') {
            $quyen_han = 'Cán bộ';
        } else {
            $quyen_han = $request->quyen_han;
        }
        TaiKhoan::create([
            'ten_dang_nhap' => $request->ten_dang_nhap,
            'mat_khau' => Hash::make(value: $request->mat_khau),
            'quyen_han' => $quyen_han,
        ]);
        session()->flash('alert-success', 'Thêm tài khoản mới thành công');
        return redirect()->back();
    }

    public function thayDoiMatKhau(Request $request)
    {
        return view('thay-doi-mat-khau');
    }

    public function xoaTaiKhoan(Request $request)
    {
        if (TaiKhoan::find($request->ma_tai_khoan)) {
            TaiKhoan::find($request->ma_tai_khoan)->delete();
            session()->flash('alert-success', 'Xóa tài khoản thành công');
            return redirect()->back();
        }
        session()->flash('alert-danger', 'Có lỗi xảy ra');
        return redirect()->back();
    }
    
    public function updateTaiKhoan(Request $request)
    {
        if (TaiKhoan::find($request->ma_tai_khoan)) {
            TaiKhoan::find($request->ma_tai_khoan)->update(['mat_khau' => Hash::make($request->mat_khau)]);;
            session()->flash('alert-success', 'Cập nhật thành công');
            return redirect()->back();
        }
        session()->flash('alert-danger', 'Có lỗi xảy ra');
        return redirect()->back();
    }
    public function thayDoiMatKhauSubmit(Request $request)
    {
        if (TaiKhoan::find($request->ma_tai_khoan)) {
            $taiKhoan = TaiKhoan::find($request->ma_tai_khoan);
            if ($request->mat_khau != '') {
                $taiKhoan->update([
                    'mat_khau' => Hash::make($request->mat_khau)
                ]);
            }

            session()->flash('alert-success', 'Cập nhật thành công');
            return redirect()->back();
        }
        session()->flash('alert-danger', 'Có lỗi xảy ra');
        return redirect()->back();
    }
}

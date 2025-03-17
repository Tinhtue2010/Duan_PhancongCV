<?php

use App\Http\Controllers\TaiKhoanController;
use App\Http\Controllers\DieuChuyenController;
use App\Http\Controllers\CanBoController;
use App\Http\Controllers\BaoCaoController;
use App\Http\Controllers\BoPhanController;
use App\Http\Controllers\DemoController;
use App\Http\Controllers\PhanCongCongViecController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home-page');
Route::get('/dang-nhap', [TaiKhoanController::class, 'dangNhap'])->name('login');
Route::post('/submit-dang-nhap', [TaiKhoanController::class, 'submitDangNhap'])->name('submit-dang-nhap');
Route::post('/dang-xuat', [TaiKhoanController::class, 'dangXuat'])->name('dang-xuat');

Route::middleware([\App\Http\Middleware\CheckRoleAdmin::class])->group(function () {
    Route::name('tai-khoan.')->group(function () {
        Route::get('/quan-ly-tai-khoan', [TaiKhoanController::class, 'danhSachTaiKhoan'])->name('danh-sach-tai-khoan');
        Route::post('/them-tai-khoan', [TaiKhoanController::class, 'themTaiKhoan'])->name('them-tai-khoan');
        Route::post('/update-tai-khoan', [TaiKhoanController::class, 'updateTaiKhoan'])->name('update-tai-khoan');
        Route::post('/xoa-tai-khoan', [TaiKhoanController::class, 'xoaTaiKhoan'])->name('xoa-tai-khoan');
    });
});

Route::middleware([\App\Http\Middleware\CheckRoleCanBo::class])->group(function () {
    Route::name('bo-phan.')->group(function () {
        Route::get('/quan-ly-bo-phan', [BoPhanController::class, 'danhSachBoPhan'])->name('danh-sach-bo-phan');
        Route::get('/can-bo-cua-bo-phan', [BoPhanController::class, 'canBoCuaBoPhan'])->name('can-bo-cua-bo-phan');
        Route::post('/them-bo-phan', [BoPhanController::class, 'themBoPhan'])->name('them-bo-phan');
        Route::post('/update-bo-phan', [BoPhanController::class, 'updateBoPhan'])->name('update-bo-phan');
        Route::post('/xoa-bo-phan', [BoPhanController::class, 'xoaBoPhan'])->name('xoa-bo-phan');
    });
    Route::name('dieu-chuyen.')->group(function () {
        Route::get('/quan-ly-dieu-chuyen', [DieuChuyenController::class, 'danhSachDieuChuyen'])->name('danh-sach-dieu-chuyen');
        Route::post('/them-dieu-chuyen', [DieuChuyenController::class, 'themDieuChuyen'])->name('them-dieu-chuyen');
        Route::post('/update-dieu-chuyen', [DieuChuyenController::class, 'updateDieuChuyen'])->name('update-dieu-chuyen');
        Route::post('/xoa-dieu-chuyen', [DieuChuyenController::class, 'xoaDieuChuyen'])->name('xoa-dieu-chuyen');
    });
    Route::name('phan-cong.')->group(function () {
        Route::get('/quan-ly-phan-cong', [PhanCongCongViecController::class, 'danhSachPhanCong'])->name('danh-sach-phan-cong');
        Route::post('/them-phan-cong', [PhanCongCongViecController::class, 'themPhanCong'])->name('them-phan-cong');
        Route::post('/update-phan-cong', [PhanCongCongViecController::class, 'updatePhanCong'])->name('update-phan-cong');
        Route::post('/xoa-phan-cong', [PhanCongCongViecController::class, 'xoaPhanCong'])->name('xoa-phan-cong');
        Route::get('/get-cong-viec', [PhanCongCongViecController::class, 'getCongViec'])->name('get-cong-viec');
    });
});
Route::name('can-bo.')->group(function () {
    Route::get('/quan-ly-can-bo', [CanBoController::class, 'danhSachCanBo'])->name('danh-sach-can-bo');
    Route::post('/them-can-bo', [CanBoController::class, 'themCanBo'])->name('them-can-bo');
    Route::post('/update-can-bo', [CanBoController::class, 'updateCanBo'])->name('update-can-bo');
    Route::post('/xoa-can-bo', [CanBoController::class, 'xoaCanBo'])->name('xoa-can-bo');
});



Route::get('demo', [DemoController::class, 'index']);
Route::get('demo2', [DemoController::class, 'demo2']);
Route::name('tai-khoan.')->group(function () {
    Route::get('/thay-doi-mat-khau', [TaiKhoanController::class, 'thayDoiMatKhau'])->name('thay-doi-mat-khau');
    Route::post('/thay-doi-mat-khau-submit', [TaiKhoanController::class, 'thayDoiMatKhauSubmit'])->name('thay-doi-mat-khau-submit');
});
Route::name('export.')->group(function () {
    Route::get('/bao-cao-hang-ton', [BaoCaoController::class, 'index'])->name('bao-cao-hang-ton');
});

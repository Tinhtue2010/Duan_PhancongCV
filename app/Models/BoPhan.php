<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoPhan extends Model
{
    protected $connection = 'mysql';
    protected $table = 'bo_phan';
    protected $primaryKey = 'ma_bo_phan';
    public $incrementing = false; // Ensure this is false if your primary key is not auto-incrementing
    protected $keyType = 'string'; // This is important if the key is a string like '61PA'}
    protected $fillable = [
        'ma_bo_phan',
        'ten_bo_phan',
        'chuc_nang_nhiem_vu',
        'thoi_gian_thanh_lap',
        'thoi_gian_giai_the',
        'trang_thai',
    ];
    // public function taiKhoan()
    // {
    //     return $this->hasMany(PhanQuyenBaoCao::class, 'ma_can_bo', 'ma_can_bo');
    // }

    public function taiKhoan()
    {
        return $this->belongsTo(TaiKhoan::class, 'ma_tai_khoan', 'ma_tai_khoan');
    }
}

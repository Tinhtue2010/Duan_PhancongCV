<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CongViec extends Model
{
    protected $connection = 'mysql';
    protected $table = 'cong_viec';
    protected $primaryKey = 'ma_cong_viec';
    public $timestamps = false;

    protected $fillable = [
        'ma_cong_viec',
        'ten_cong_viec',
        'ma_bo_phan',
        'loai_cong_viec',
        'thoi_han_hoan_thanh',
        'trang_thai',
    ];
    // public function taiKhoan()
    // {
    //     return $this->hasMany(PhanQuyenBaoCao::class, 'ma_can_bo', 'ma_can_bo');
    // }
    public function boPhan()
    {
        return $this->belongsTo(BoPhan::class, 'ma_bo_phan', 'ma_bo_phan');
    }
    public function taiKhoan()
    {
        return $this->belongsTo(TaiKhoan::class, 'ma_tai_khoan', 'ma_tai_khoan');
    }
}

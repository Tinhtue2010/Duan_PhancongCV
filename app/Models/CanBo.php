<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CanBo extends Model
{
    protected $connection = 'mysql';
    protected $table = 'can_bo';
    protected $primaryKey = 'ma_can_bo';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = [
        'ma_can_bo',
        'ma_bo_phan',
        'ten_can_bo',
        'chuc_danh',
        'trang_thai',
        'ma_tai_khoan',
        'nhom_vi_tri_lam_viec',
    ];

    public function boPhan()
    {
        return $this->belongsTo(BoPhan::class, 'ma_bo_phan', 'ma_bo_phan');
    }
    public function taiKhoan()
    {
        return $this->belongsTo(TaiKhoan::class, 'ma_tai_khoan', 'ma_tai_khoan');
    }
}

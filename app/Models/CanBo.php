<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CanBo extends Model
{
    protected $connection = 'mysql';
    protected $table = 'can_bo';
    protected $primaryKey = 'ma_can_bo';
    public $incrementing = false; // Ensure this is false if your primary key is not auto-incrementing
    protected $keyType = 'string'; // This is important if the key is a string like '61PA'}
    public $timestamps = false;
    protected $fillable = [
        'ma_can_bo',
        'ma_bo_phan',
        'ten_can_bo',
        'ngay_sinh',
        'trinh_do',
        'chuyen_mon',
        'chuc_danh',
        'ngay_tuyen_dung',
        'trang_thai',
        'ma_tai_khoan',
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

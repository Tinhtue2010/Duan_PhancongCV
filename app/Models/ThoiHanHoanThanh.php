<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThoiHanHoanThanh extends Model
{
    protected $connection = 'mysql';
    protected $table = 'thoi_han_hoan_thanh';
    protected $primaryKey = 'ma_thoi_han';
    protected $fillable = [
        'ma_thoi_han',
        'ma_cong_viec',
        'moc_thoi_gian',
        'ngay_het_han',
        'thang_het_han',
        'noi_nhan',
    ];
    public function congViec()
    {
        return $this->belongsTo(CongViec::class, 'ma_cong_viec', 'ma_cong_viec');
    }
}

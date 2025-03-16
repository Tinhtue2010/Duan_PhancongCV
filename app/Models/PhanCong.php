<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhanCong extends Model
{
    protected $connection = 'mysql';
    protected $table = 'phan_cong';
    protected $primaryKey = 'ma_phan_cong';

    protected $fillable = [
        'ma_phan_cong',
        'ma_cong_viec',
        'ma_can_bo_giao',
        'ma_can_bo_nhan',
        'ngay_phan_cong',
        'ngay_nhan_viec',
        'chi_tiet',
    ];
    public function canBoGiao()
    {
        return $this->belongsTo(CanBo::class, 'ma_can_bo_giao', 'ma_can_bo');
    }
    public function canBoNhan()
    {
        return $this->belongsTo(CanBo::class, 'ma_can_bo_nhan', 'ma_can_bo');
    }
}

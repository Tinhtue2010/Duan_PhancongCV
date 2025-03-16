<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DieuChuyen extends Model
{
    protected $connection = 'mysql';
    protected $table = 'dieu_chuyen';
    protected $primaryKey = 'ma_dieu_chuyen';

    protected $fillable = [
        'ma_dieu_chuyen',
        'ma_can_bo',
        'thoi_gian_dieu_chuyen',
        'ma_bo_phan_chuyen_den',
        'chuc_danh_moi',
        'ly_do',
    ];
    public function boPhanChuyenDen()
    {
        return $this->belongsTo(BoPhan::class, 'ma_bo_phan_chuyen_den', 'ma_bo_phan');
    }
    public function canBo()
    {
        return $this->belongsTo(CanBo::class, 'ma_can_bo', 'ma_can_bo');
    }
}

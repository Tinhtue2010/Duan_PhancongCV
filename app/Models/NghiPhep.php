<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NghiPhep extends Model
{
    protected $connection = 'mysql';
    protected $table = 'nghi_phep';
    protected $primaryKey = 'ma_nghi_phep';
    protected $fillable = [
        'ma_nghi_phep',
        'ma_can_bo',
        'ngay_lam_viec',
        'tu_gio',
        'den_gio',
        'ngay_bat_dau',
        'ngay_ket_thuc',
        'ly_do_vang',
    ];
    public function canBo()
    {
        return $this->belongsTo(CanBo::class, 'ma_can_bo', 'ma_can_bo');
    }

}

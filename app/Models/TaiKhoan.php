<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Access\Authorizable;             // <-- add import

class TaiKhoan extends Authenticatable
{
    use HasFactory, Notifiable, Authorizable;
    
    protected $connection = 'mysql';
    protected $table = 'tai_khoan';
    protected $primaryKey = 'ma_tai_khoan';

    protected $fillable = [
        'ten_dang_nhap',
        'mat_khau',
        'quyen_han',
    ];
    protected $hidden = [
        'mat_khau',
        'remember_token',
    ];
    protected function casts(): array
{
    return [
        'mat_khau' => 'hashed',
    ];
}
    public function getAuthPassword()
    {
        return $this->mat_khau;
    }

    public function canBo()
    {
        return $this->hasOne(CanBo::class, 'ma_tai_khoan', 'ma_tai_khoan');
    }
}

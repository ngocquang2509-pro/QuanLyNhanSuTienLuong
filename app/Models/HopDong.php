<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HopDong extends Model
{
    use HasFactory;

    protected $table = 'hopdong';
    protected $fillable = [
        'nhanvien_id',
        'LoaiHopDong',
        'ngay_bat_dau',
        'ngay_ket_thuc',
        'ngay_ky',
        'noi_dung',
        'TaiKhoan'
    ];

    public function nhanVien()
    {
        return $this->belongsTo(NhanVien::class, 'nhanvien_id');
    }
}

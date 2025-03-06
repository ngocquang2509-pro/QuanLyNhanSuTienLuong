<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NhanVien extends Model
{
    use HasFactory;

    protected $table = 'nhanvien';
    protected $fillable = [
        'HoTen',
        'GioiTinh',
        'NgaySinh',
        'DienThoai',
        'CCCD',
        'Email',
        'DiaChi',
        'MaPhongBan',
        'MaChucVu'
    ];

    public function phongBan()
    {
        return $this->belongsTo(PhongBan::class, 'MaPhongBan');
    }

    public function chucVu()
    {
        return $this->belongsTo(ChucVu::class, 'MaChucVu');
    }
    public function hopDong()
    {
        return $this->hasOne(HopDong::class, 'nhanvien_id');
    }
}

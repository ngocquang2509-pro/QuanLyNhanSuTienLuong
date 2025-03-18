<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChamCong extends Model
{
    protected $table = 'chamcong';
    protected $fillable = [
        'nhanvien_id',
        'NgayLamViec',
        'NgayGioVao',
        'NgayGioRa',
        'NguonMay',
        'SoCong',
        'TrangThai'
    ];
    public function nhanVien()
    {
        return $this->belongsTo(NhanVien::class, 'nhanvien_id');
    }
    public function lichLamViec()
    {
        return $this->belongsTo(LichLamViec::class, 'lichlamviec_id');
    }
}

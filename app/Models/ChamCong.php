<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChamCong extends Model
{
    protected $table = 'chamcong';
    protected $fillable = [
        'NgayLamViec',
        'GioVao',
        'GioRa',
        'NguonMay',
        'SoCong',
        'TrangThai',
        'nhanvien_id'
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
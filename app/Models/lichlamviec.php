<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class lichlamviec extends Model
{
    protected $table = 'lichlamviec';
    protected $fillable = ['id', 'NgayLamViec', 'nhanvien_id', 'ca_id', 'MoTa'];
    public $timestamps = false;
    public function nhanVien()
    {
        return $this->belongsTo(NhanVien::class, 'nhanvien_id');
    }
    public function caLamViec()
    {
        return $this->belongsTo(calamviec::class, 'ca_id');
    }
    public function chamCong()
    {
        return $this->hasMany(ChamCong::class, 'lichlamviec_id');
    }
}

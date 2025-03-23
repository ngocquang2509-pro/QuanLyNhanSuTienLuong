<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KTKL extends Model
{
    protected $table = '_khen_thuong_ki_luat_nhan_vien';
    protected $fillable = ['KTKL_id', 'nhanvien_id', 'NoiDung'];
    public function nhanVien()
    {
        return $this->belongsTo(NhanVien::class, 'nhanvien_id');
    }
}

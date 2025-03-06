<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChucVu extends Model
{
    use HasFactory;

    protected $table = 'chucvu';
    protected $fillable = ['TenChucVu', 'LuongCoBan'];

    public function nhanViens()
    {
        return $this->hasMany(NhanVien::class, 'MaChucVu');
    }
}

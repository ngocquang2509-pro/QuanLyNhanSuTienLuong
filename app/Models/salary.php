<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class salary extends Model
{
    protected $table = '_luong';
    protected $fillable = ['HoTen', 'ChucVu', 'PhongBan', 'LuongCoBan', 'pc_chuc_vu', 'pc_trach_nhiem', 'SoNgayCong', 'TongThuNhap', 'bhxh', 'bhyt', 'thue_tncn', 'luong_thuc_lanh', 'tam_ung', 'con_lanh', 'NgayTao'];
}

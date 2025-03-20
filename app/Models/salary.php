<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class salary extends Model
{
    use HasFactory;

    protected $table = '_luong';
    
    protected $fillable = [
        'nhanvien_id', 'HoTen', 'ChucVu', 'PhongBan', 'LuongCB', 'pc_chuc_vu', 
        'pc_trach_nhiem', 'SoNgayCong', 'TongThuNhap', 'bhxh', 
        'bhyt', 'bhtn', 'thue_tncn', 'luong_thuc_lanh', 'tam_ung', 
        'con_lanh', 'NgayTao', 'NgayThanhToan'
    ];
    
    // Chuyển đổi các trường date
    protected $dates = [
        'NgayTao',
        'NgayThanhToan',
        'created_at',
        'updated_at'
    ];
    
    // Xác định kiểu dữ liệu cho các trường
    protected $casts = [
        'LuongCB' => 'decimal:2',
        'pc_chuc_vu' => 'decimal:2',
        'pc_trach_nhiem' => 'decimal:2',
        'TongThuNhap' => 'decimal:2',
        'bhxh' => 'decimal:2',
        'bhyt' => 'decimal:2',
        'bhtn' => 'decimal:2',
        'thue_tncn' => 'decimal:2',
        'luong_thuc_lanh' => 'decimal:2',
        'tam_ung' => 'decimal:2',
        'con_lanh' => 'decimal:2',
        'NgayTao' => 'date',
        'NgayThanhToan' => 'datetime'
    ];
    
    /**
     * Quan hệ với bảng nhân viên
     */
    public function nhanVien()
    {
        return $this->belongsTo(NhanVien::class, 'nhanvien_id');
    }
    
    /**
     * Quan hệ với bảng phiếu lương
     */
    public function phieuLuong()
    {
        return $this->hasMany('App\Models\PhieuLuong', 'Luong_id');
    }
}
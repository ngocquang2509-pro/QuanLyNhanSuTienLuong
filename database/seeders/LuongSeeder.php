<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NhanVien;
use App\Models\salary;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LuongSeeder extends Seeder
{
    public function run()
    {
        // Xóa dữ liệu phiếu lương trước
        DB::table('_phieu_luong')->delete();
        
        // Sau đó mới xóa dữ liệu lương
        DB::table('_luong')->delete();
        
        // Lấy tất cả nhân viên
        $nhanviens = NhanVien::with(['chucVu', 'phongBan'])->get();
        
        foreach ($nhanviens as $nv) {
            // Bỏ qua nếu không có chức vụ hoặc phòng ban
            if (!$nv->chucVu || !$nv->phongBan) {
                continue;
            }
            
            // Tính toán các giá trị lương
            $luongCB = $nv->chucVu->LuongCoBan ?? 5000000;
            $pcChucVu = $nv->chucVu->PC_Chuc_vu ?? 500000;
            $pcTrachNhiem = $nv->chucVu->PC_Trach_nhiem ?? 300000;
            $soNgayCong = rand(20, 22); // Giả định số ngày công
            $tongThuNhap = $luongCB + $pcChucVu + $pcTrachNhiem;
            
            // Tính các khoản khấu trừ
            $bhxh = round($luongCB * 0.08);
            $bhyt = round($luongCB * 0.015);
            $bhtn = 0; // Bảo hiểm thất nghiệp 
            $thueTncn = 0; // Thuế thu nhập cá nhân
            
            // Tính lương thực lãnh
            $luongThucLanh = $tongThuNhap - $bhxh - $bhyt - $thueTncn;
            
            // Tạo bản ghi lương
            salary::create([
                'HoTen' => $nv->HoTen,
                'ChucVu' => $nv->chucVu->TenChucVu,
                'PhongBan' => $nv->phongBan->TenPhongBan,
                'LuongCB' => $luongCB,
                'pc_chuc_vu' => $pcChucVu,
                'pc_trach_nhiem' => $pcTrachNhiem,
                'SoNgayCong' => $soNgayCong,
                'TongThuNhap' => $tongThuNhap,
                'bhxh' => $bhxh,
                'bhyt' => $bhyt,
                'bhtn' => $bhtn,
                'thue_tncn' => $thueTncn,
                'luong_thuc_lanh' => $luongThucLanh,
                'tam_ung' => 0,
                'con_lanh' => $luongThucLanh,
                'NgayTao' => Carbon::now()->format('Y-m-d'),
                'NgayThanhToan' => null
            ]);
        }
    }
}
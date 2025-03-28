<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HopDongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $id = 1;
        $phongBans = DB::table('phongban')->pluck('id');

        foreach ($phongBans as $phongBan) {
            // Lấy danh sách nhân viên có chức vụ từ 1 đến 4
            $nhanViens = DB::table('nhanvien')
                ->where('MaPhongBan', $phongBan)
                ->whereIn('MaChucVu', [1, 2, 3, 4]) // Lấy tất cả nhân viên có chức vụ 1, 2, 3, 4
                ->pluck('id')
                ->toArray();

            if (empty($nhanViens)) {
                continue; // Nếu không có nhân viên thì bỏ qua phòng này
            }

            // Chỉ lấy nhân viên có chức vụ 1 để chọn làm thời vụ
            $nhanViensThoiVu = DB::table('nhanvien')
                ->where('MaPhongBan', $phongBan)
                ->where('MaChucVu', 1) // Chỉ nhân viên có chức vụ 1 mới có thể là thời vụ
                ->pluck('id')
                ->toArray();

            if (!empty($nhanViensThoiVu)) {
                // Chọn ngẫu nhiên 1 nhân viên có chức vụ 1 làm nhân viên thời vụ
                $nhanVienThoiVu = array_shift($nhanViensThoiVu); // Lấy ID đầu tiên và xóa khỏi danh sách

                // Tạo hợp đồng cho nhân viên thời vụ
                DB::table('hopdong')->insert([
                    'id' => $id++,
                    'nhanvien_id' => $nhanVienThoiVu,
                    'LoaiHopDong' => 'Nhân viên thời vụ',
                    'ngay_bat_dau' => Carbon::now()->subMonths(3)->startOfMonth(),
                    'ngay_ket_thuc' => Carbon::now()->subMonths(3)->startOfMonth()->addMonths(3),
                    'ngay_ky' => Carbon::now()->subMonths(3)->startOfMonth(),
                    'noi_dung' => 'Hợp đồng nhân viên thời vụ',
                    'LuongCoBan' => rand(22500, 25000),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'NPT' => 0
                ]);

                // Loại bỏ nhân viên thời vụ khỏi danh sách nhân viên chính thức
                $nhanViens = array_diff($nhanViens, [$nhanVienThoiVu]);
            }

            // Tạo hợp đồng cho tất cả nhân viên còn lại (chính thức)
            foreach ($nhanViens as $nhanVien) {
                DB::table('hopdong')->insert([
                    'id' => $id++,
                    'nhanvien_id' => $nhanVien,
                    'LoaiHopDong' => 'Nhân viên chính thức',
                    'ngay_bat_dau' => Carbon::now()->subMonths(6)->startOfMonth(),
                    'ngay_ket_thuc' => null,
                    'ngay_ky' => Carbon::now()->subMonths(6)->startOfMonth(),
                    'noi_dung' => 'Hợp đồng nhân viên chính thức',
                    'LuongCoBan' => rand(4680000, 6000000),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'NPT' => 0
                ]);
            }
        }
    }
}

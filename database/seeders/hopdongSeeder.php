<?php

namespace Database\Seeders;

use App\Models\HopDong;
use App\Models\NhanVien;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class hopdongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $id = 1;
        $phongBans = DB::table('phongban')->pluck('id');

        foreach ($phongBans as $phongBan) {
            // Lấy danh sách nhân viên của phòng này, chỉ chọn nhân viên có chức vụ 'Nhân viên'
            $nhanViens = DB::table('nhanvien')
                ->where('MaPhongBan', $phongBan)
                ->where('MaChucVu', 1) // Chỉ nhân viên (id chức vụ = 1)
                ->pluck('id')
                ->toArray();

            if (empty($nhanViens)) {
                continue; // Nếu không có nhân viên thì bỏ qua phòng này
            }

            // Chọn ngẫu nhiên 1 nhân viên trong danh sách để làm nhân viên thời vụ
            $nhanVienThoiVu = array_shift($nhanViens); // Lấy ID đầu tiên và xóa khỏi danh sách

            // Tạo hợp đồng cho nhân viên thời vụ
            DB::table('hopdong')->insert([
                'id' => $id++,
                'nhanvien_id' => $nhanVienThoiVu,
                'LoaiHopDong' => 'Nhân viên thời vụ',
                'ngay_bat_dau' => Carbon::now()->subMonths(3)->startOfMonth(), // 3 tháng trước
                'ngay_ket_thuc' => Carbon::now()->subMonths(3)->startOfMonth()->addMonths(3), // Kết thúc sau 3 tháng
                'ngay_ky' => Carbon::now()->subMonths(3)->startOfMonth(),
                'noi_dung' => 'Hợp đồng nhân viên thời vụ',
                'created_at' => now(),
                'updated_at' => now(),
                'NPT' => 0
            ]);

            // Tạo hợp đồng cho nhân viên chính thức còn lại
            foreach ($nhanViens as $nhanVien) {
                DB::table('hopdong')->insert([
                    'id' => $id++,
                    'nhanvien_id' => $nhanVien,
                    'LoaiHopDong' => 'Nhân viên chính thức',
                    'ngay_bat_dau' => Carbon::now()->subMonths(6)->startOfMonth(), // 6 tháng trước
                    'ngay_ket_thuc' => null, // Không có ngày kết thúc
                    'ngay_ky' => Carbon::now()->subMonths(6)->startOfMonth(),
                    'noi_dung' => 'Hợp đồng nhân viên chính thức',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'NPT' => 0
                ]);
            }
        }
    }
}

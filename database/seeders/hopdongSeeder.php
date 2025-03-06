<?php

namespace Database\Seeders;

use App\Models\HopDong;
use App\Models\NhanVien;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class hopdongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = NhanVien::all();
        $loaiHopDongs = ['Hợp đồng thử việc', 'Hợp đồng lao động có thời hạn', 'Hợp đồng lao động không thời hạn'];

        foreach ($employees as $employee) {
            $ngayKy = Carbon::now()->subMonths(rand(1, 36)); // Ngày ký hợp đồng ngẫu nhiên trong vòng 3 năm trước
            $thoiHan = rand(6, 36); // Hợp đồng có thời hạn từ 6 tháng đến 3 năm
            $ngayBatDau = $ngayKy->copy()->addDays(rand(1, 30)); // Ngày bắt đầu sau ngày ký từ 1-30 ngày
            $ngayKetThuc = $ngayBatDau->copy()->addMonths($thoiHan); // Ngày kết thúc hợp đồng
            HopDong::create([
                'nhanvien_id' => $employee->id,
                'LoaiHopDong' => $loaiHopDongs[array_rand($loaiHopDongs)], // Chọn ngẫu nhiên loại hợp đồng
                'ngay_bat_dau' => $ngayBatDau,
                'ngay_ket_thuc' => $ngayKetThuc,
                'ngay_ky' => $ngayKy,
                'noi_dung' => 'Hợp đồng lao động giữa công ty và nhân viên ' . $employee->HoTen . ' có hiệu lực từ ' . $ngayBatDau->format('d/m/Y') . ' đến ' . $ngayKetThuc->format('d/m/Y') . '.',
            ]);
        }
    }
}

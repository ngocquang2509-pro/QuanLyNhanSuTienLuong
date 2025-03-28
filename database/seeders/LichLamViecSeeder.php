<?php

namespace Database\Seeders;

use App\Models\NhanVien;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LichLamViecSeeder extends Seeder
{
    public function run()
    {
        $id = 1;
        $fulltimeCaId = 1;
        $tangCaId = 3;
        $congTacCaId = 5;
        $parttimeCaId = 2; // Ca làm việc Part-time

        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        // Lấy danh sách nhân viên chính thức
        $nhanvienchinhthucs = NhanVien::whereHas('hopdong', function ($query) {
            $query->where('LoaiHopDong', 'Nhân viên chính thức');
        })->get();

        // Lấy danh sách nhân viên thời vụ
        $nhanvienthoivu = NhanVien::whereHas('hopdong', function ($query) {
            $query->where('LoaiHopDong', 'Nhân viên thời vụ');
        })->get();

        // Thêm lịch làm việc cho nhân viên chính thức
        foreach ($nhanvienchinhthucs as $nhanvienchinhthuc) {
            for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
                if ($date->isWeekend()) {
                    continue; // Bỏ qua thứ 7, chủ nhật
                }

                // Thêm ca Fulltime cho tất cả nhân viên chính thức
                DB::table('lichlamviec')->insert([
                    'id' => $id++,
                    'NgayLamViec' => $date->format('Y-m-d'),
                    'nhanvien_id' => $nhanvienchinhthuc->id,
                    'ca_id' => $fulltimeCaId,
                ]);

                // Nếu là giám đốc thì thêm ca công tác
                if ($nhanvienchinhthuc->MaChucVu == 3) {
                    DB::table('lichlamviec')->insert([
                        'id' => $id++,
                        'NgayLamViec' => $date->format('Y-m-d'),
                        'nhanvien_id' => $nhanvienchinhthuc->id,
                        'ca_id' => $congTacCaId,
                    ]);
                }

                // Nếu là trưởng phòng thì thêm ca tăng ca
                if ($nhanvienchinhthuc->MaChucVu == 2) {
                    DB::table('lichlamviec')->insert([
                        'id' => $id++,
                        'NgayLamViec' => $date->format('Y-m-d'),
                        'nhanvien_id' => $nhanvienchinhthuc->id,
                        'ca_id' => $tangCaId,
                    ]);
                }
            }
        }

        // Thêm lịch làm việc cho nhân viên thời vụ
        foreach ($nhanvienthoivu as $nhanvienthoivucanhan) {
            for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
                if ($date->isWeekend()) {
                    continue; // Bỏ qua thứ 7, chủ nhật
                }

                // Thêm ca Part-time cho nhân viên thời vụ
                DB::table('lichlamviec')->insert([
                    'id' => $id++,
                    'NgayLamViec' => $date->format('Y-m-d'),
                    'nhanvien_id' => $nhanvienthoivucanhan->id,
                    'ca_id' => $parttimeCaId,
                ]);
            }
        }
    }
}

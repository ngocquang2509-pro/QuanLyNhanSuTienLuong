<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LichLamViecSeeder extends Seeder
{
    public function run()
    {
        $id = 1;
        $nhanviens = DB::table('nhanvien')->get();
        $fulltimeCaId = 1;
        $tangCaId = 2;
        $congTacCaId = 4;

        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        foreach ($nhanviens as $nhanvien) {
            for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
                if ($date->isWeekend()) {
                    continue; // Bỏ qua thứ 7, chủ nhật
                }

                // Thêm ca Fulltime cho tất cả nhân viên
                DB::table('lichlamviec')->insert([
                    'id' => $id++,
                    'NgayLamViec' => $date->format('Y-m-d'),
                    'nhanvien_id' => $nhanvien->id,
                    'ca_id' => $fulltimeCaId,
                ]);

                // Nếu là giám đốc thì thêm ca công tác
                if ($nhanvien->MaChucVu == 3) {
                    DB::table('lichlamviec')->insert([
                        'id' => $id++,
                        'NgayLamViec' => $date->format('Y-m-d'),
                        'nhanvien_id' => $nhanvien->id,
                        'ca_id' => $congTacCaId,
                    ]);
                }

                // Nếu là trưởng phòng thì thêm ca tăng ca
                if ($nhanvien->MaChucVu == 2) {
                    DB::table('lichlamviec')->insert([
                        'id' => $id++,
                        'NgayLamViec' => $date->format('Y-m-d'),
                        'nhanvien_id' => $nhanvien->id,
                        'ca_id' => $tangCaId,
                    ]);
                }
            }
        }
    }
}

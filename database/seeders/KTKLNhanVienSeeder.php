<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KTKLNhanVienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy danh sách nhân viên
        $nhanvien_ids = DB::table('nhanvien')->pluck('id')->toArray();
        $ktkl_map = DB::table('_khen_thuong_ki_luat')->pluck('Loai', 'id')->toArray();

        // Kiểm tra dữ liệu có sẵn không
        if (empty($nhanvien_ids) || empty($ktkl_map)) {
            $this->command->warn("Bảng 'nhanvien' hoặc '_khen_thuong_ki_luat' không có dữ liệu. Seeder dừng lại.");
            return;
        }

        foreach ($nhanvien_ids as $index => $nhanvien_id) {
            $ktkl_id = array_search('Khen thưởng', $ktkl_map); // Lấy ID của "Khen thưởng"

            // Nhân viên cuối cùng sẽ nhận "Kỷ luật"
            if ($index === array_key_last($nhanvien_ids)) {
                $ktkl_id = array_search('Kỷ luật', $ktkl_map); // Lấy ID của "Kỷ luật"
            }

            // Chèn trực tiếp vào bảng
            DB::table('_khen_thuong_ki_luat_nhan_vien')->insert([
                'KTKL_id' => $ktkl_id,
                'nhanvien_id' => $nhanvien_id,
                'NoiDung' => 1000000, // Số tiền là 1.000.000
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

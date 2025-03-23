<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class bacluongChucvuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bacluong_ids = DB::table('bacluong')->pluck('id')->toArray();
        $chucvu_map = DB::table('chucvu')->pluck('TenChucVu', 'id')->toArray();

        // Kiểm tra nếu không có dữ liệu
        if (empty($bacluong_ids) || empty($chucvu_map)) {
            $this->command->warn("Bảng 'chucvu' hoặc 'bacluong' không có dữ liệu. Seeder dừng lại.");
            return;
        }

        $data = [];

        foreach ($chucvu_map as $chucvu_id => $TenChucVu) {
            foreach ($bacluong_ids as $bacluong_id) {
                // Xác định hệ số dựa trên chức vụ và bậc lương
                $base_he_so = match ($TenChucVu) {
                    'Nhân viên', 'Cố vấn' => 1.0,
                    'Trưởng phòng' => 1.5,
                    'Giám đốc' => 2.0,
                    default => 1.0, // Mặc định nếu có chức vụ khác
                };

                // Hệ số tăng dần theo bậc lương
                $HeSo = $base_he_so + ($bacluong_id - 1) * 0.2;

                $data[] = [
                    'chucvu_id' => $chucvu_id,
                    'bacluong_id' => $bacluong_id,
                    'HeSo' => round($HeSo, 2),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Chèn dữ liệu vào bảng
        DB::table('bacluong_chucvu')->insert($data);
    }
}

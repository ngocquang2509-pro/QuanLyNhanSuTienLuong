<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChucVuSeeder extends Seeder
{
    public function run(): void
    {


        DB::table('chucvu')->insert([
            [
                'id' => 1,
                'TenChucVu' => 'Nhân viên',
                'LuongCoBan' => 15000000,
                'PC_Chuc_vu' => 1000000,
                'PC_Trach_nhiem' => 800000,
                'created_at' => '2025-02-26 09:17:49',
                'updated_at' => '2025-02-26 09:17:49',
            ],
            [
                'id' => 2,
                'TenChucVu' => 'Trưởng phòng',
                'LuongCoBan' => 20000000,
                'PC_Chuc_vu' => 1500000,
                'PC_Trach_nhiem' => 1000000,
                'created_at' => '2025-02-26 09:17:49',
                'updated_at' => '2025-02-28 01:31:38',
            ],
            [
                'id' => 3,
                'TenChucVu' => 'Giám đốc',
                'LuongCoBan' => 30000000,
                'PC_Chuc_vu' => 2000000,
                'PC_Trach_nhiem' => 2000000,
                'created_at' => '2025-02-26 09:17:49',
                'updated_at' => '2025-02-28 01:33:23',
            ],
            [
                'id' => 4,
                'TenChucVu' => 'Cố vấn',
                'LuongCoBan' => 15000000,
                'PC_Chuc_vu' => 1000000,
                'PC_Trach_nhiem' => 1000000,
                'created_at' => '2025-03-14 05:09:05',
                'updated_at' => '2025-03-15 14:23:49',
            ],
        ]);
    }
}

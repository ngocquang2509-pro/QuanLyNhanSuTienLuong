<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhongBanSeeder extends Seeder
{
    public function run(): void
    {


        DB::table('phongban')->insert([
            [
                'id' => 1,
                'TenPhongBan' => 'Hành chính',
                'created_at' => '2025-02-26 09:18:08',
                'updated_at' => '2025-02-26 09:18:08',
            ],
            [
                'id' => 2,
                'TenPhongBan' => 'Kế toán',
                'created_at' => '2025-02-26 09:18:09',
                'updated_at' => '2025-02-26 09:18:09',
            ],
            [
                'id' => 3,
                'TenPhongBan' => 'Nhân sự',
                'created_at' => '2025-02-26 09:18:09',
                'updated_at' => '2025-02-26 09:18:09',
            ],
            [
                'id' => 4,
                'TenPhongBan' => 'Kinh doanh',
                'created_at' => '2025-02-26 09:18:09',
                'updated_at' => '2025-02-26 09:18:09',
            ],
            [
                'id' => 5,
                'TenPhongBan' => 'Kĩ thuật',
                'created_at' => '2025-03-14 05:06:44',
                'updated_at' => '2025-03-14 05:06:44',
            ],
            [
                'id' => 6,
                'TenPhongBan' => 'Sản xuất',
                'created_at' => '2025-03-14 05:08:04',
                'updated_at' => '2025-03-14 05:08:04',
            ],
            [
                'id' => 7,
                'TenPhongBan' => 'Nghiên cứu và phát triển',
                'created_at' => '2025-03-14 05:08:34',
                'updated_at' => '2025-03-14 05:08:34',
            ],

        ]);
    }
}

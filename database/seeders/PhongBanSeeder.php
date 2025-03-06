<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhongBanSeeder extends Seeder
{
    public function run(): void
    {
        $departments = ['Hành chính', 'Kế toán', 'Nhân sự', 'Kinh doanh', 'Công nghệ'];

        foreach ($departments as $department) {
            DB::table('phongban')->insert([
                'TenPhongBan' => $department,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

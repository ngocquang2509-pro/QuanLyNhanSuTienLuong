<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChucVuSeeder extends Seeder
{
    public function run(): void
    {
        $positions = [
            ['TenChucVu' => 'Nhân viên', 'LuongCoBan' => 7000000],
            ['TenChucVu' => 'Trưởng phòng', 'LuongCoBan' => 15000000],
            ['TenChucVu' => 'Giám đốc', 'LuongCoBan' => 30000000],
        ];

        foreach ($positions as $position) {
            DB::table('chucvu')->insert([
                'TenChucVu' => $position['TenChucVu'],
                'LuongCoBan' => $position['LuongCoBan'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CaLamViecSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('calamviec')->insert([
            ['TenLoaiCa' => 'Ca sáng', 'Giobatdau' => '08:00:00', 'Gioketthuc' => '17:00:00', 'type' => 'regular'],
            ['TenLoaiCa' => 'Ca chiều', 'Giobatdau' => '18:00:00', 'Gioketthuc' => '02:00:00', 'type' => 'special'],
            ['TenLoaiCa' => 'Làm thêm giờ', 'Giobatdau' => '18:00:00', 'Gioketthuc' => '00:00:00', 'type' => 'overtime'],
            ['TenLoaiCa' => 'Công tác', 'Giobatdau' => '00:00:00', 'Gioketthuc' => '00:00:00', 'type' => 'business_trip'],
            ['TenLoaiCa' => 'Nghỉ phép', 'Giobatdau' => null, 'Gioketthuc' => null, 'type' => 'leave'],
        ]);
    }
}

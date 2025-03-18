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
            [
                'id' => 1,
                'TenLoaiCa' => 'Fulltime',
                'Giobatdau' => '08:00:00',
                'Gioketthuc' => '17:00:00',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 2,
                'TenLoaiCa' => 'Tăng ca',
                'Giobatdau' => '17:00:00',
                'Gioketthuc' => '20:00:00',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 3,
                'TenLoaiCa' => 'Nghỉ phép',
                'Giobatdau' => null,
                'Gioketthuc' => null,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 4,
                'TenLoaiCa' => 'Công tác',
                'Giobatdau' => '08:00:00',
                'Gioketthuc' => '17:00:00',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => 5,
                'TenLoaiCa' => 'Làm việc đặc biệt',
                'Giobatdau' => '08:00:00',
                'Gioketthuc' => '17:00:00',
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);
    }
}

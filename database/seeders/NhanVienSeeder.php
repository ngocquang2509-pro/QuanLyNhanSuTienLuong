<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class NhanVienSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $phongBanIds = DB::table('phongban')->pluck('id')->toArray();
        $chucVuIds = DB::table('chucvu')->pluck('id')->toArray();

        for ($i = 0; $i < 15; $i++) { // Tạo 15 nhân viên
            DB::table('nhanvien')->insert([
                'HoTen' => $faker->name,
                'GioiTinh' => $faker->randomElement(['Nam', 'Nữ']),
                'NgaySinh' => $faker->date(),
                'DienThoai' => $faker->phoneNumber,
                'CCCD' => $faker->unique()->numerify('###########'),
                'Email' => $faker->unique()->safeEmail,
                'DiaChi' => $faker->address,
                'MaPhongBan' => $faker->randomElement($phongBanIds),
                'MaChucVu' => $faker->randomElement($chucVuIds),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

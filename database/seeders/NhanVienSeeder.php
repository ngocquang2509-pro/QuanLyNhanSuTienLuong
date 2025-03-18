<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class NhanVienSeeder extends Seeder
{
    public function run(): void
    {
        $id = 1;

        $faker = Faker::create('vi_VN');

        $phongBans = DB::table('phongban')->pluck('id'); // Lấy danh sách ID phòng ban
        $chucVus = [
            'Giám đốc' => 3,
            'Trưởng phòng' => 2,
            'Cố vấn' => 4,
            'Nhân viên' => 1
        ];

        foreach ($phongBans as $phongBan) {
            // Thêm 1 Giám đốc
            DB::table('nhanvien')->insert([
                'id' => $id++,
                'HoTen' => $faker->name,
                'GioiTinh' => $faker->randomElement(['Nam', 'Nữ']),
                'NgaySinh' => $faker->date,
                'DienThoai' => $faker->phoneNumber,
                'CCCD' => $faker->unique()->numerify('0############'),
                'Email' => $faker->unique()->email,
                'DiaChi' => $faker->address,
                'MaPhongBan' => $phongBan,
                'MaChucVu' => $chucVus['Giám đốc'],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Thêm 1 Trưởng phòng
            DB::table('nhanvien')->insert([
                'id' => $id++,
                'HoTen' => $faker->name,
                'GioiTinh' => $faker->randomElement(['Nam', 'Nữ']),
                'NgaySinh' => $faker->date,
                'DienThoai' => $faker->phoneNumber,
                'CCCD' => $faker->unique()->numerify('0############'),
                'Email' => $faker->unique()->email,
                'DiaChi' => $faker->address,
                'MaPhongBan' => $phongBan,
                'MaChucVu' => $chucVus['Trưởng phòng'],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Thêm 2 Cố vấn
            for ($i = 0; $i < 2; $i++) {
                DB::table('nhanvien')->insert([
                    'id' => $id++,
                    'HoTen' => $faker->name,
                    'GioiTinh' => $faker->randomElement(['Nam', 'Nữ']),
                    'NgaySinh' => $faker->date,
                    'DienThoai' => $faker->phoneNumber,
                    'CCCD' => $faker->unique()->numerify('0############'),
                    'Email' => $faker->unique()->email,
                    'DiaChi' => $faker->address,
                    'MaPhongBan' => $phongBan,
                    'MaChucVu' => $chucVus['Cố vấn'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            // Thêm 6 Nhân viên
            for ($i = 0; $i < 6; $i++) {
                DB::table('nhanvien')->insert([
                    'id' => $id++,
                    'HoTen' => $faker->name,
                    'GioiTinh' => $faker->randomElement(['Nam', 'Nữ']),
                    'NgaySinh' => $faker->date,
                    'DienThoai' => $faker->phoneNumber,
                    'CCCD' => $faker->unique()->numerify('0############'),
                    'Email' => $faker->unique()->email,
                    'DiaChi' => $faker->address,
                    'MaPhongBan' => $phongBan,
                    'MaChucVu' => $chucVus['Nhân viên'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
}
